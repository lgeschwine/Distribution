<?php

namespace UJM\ExoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;

use UJM\ExoBundle\Entity\InteractionQCM;
use UJM\ExoBundle\Form\InteractionQCMType;
use UJM\ExoBundle\Form\InteractionQCMHandler;

/**
 * InteractionQCM controller.
 *
 */
class InteractionQCMController extends Controller
{

    /**
     * Creates a new InteractionQCM entity.
     *
     * @access public
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction()
    {
        $services = $this->container->get('ujm.exo_InteractionQCM');
        $interQCM  = new InteractionQCM();
        $form      = $this->createForm(
            new InteractionQCMType(
                $this->container->get('security.token_storage')->getToken()->getUser()
            ), $interQCM
        );

        $exoID = $this->container->get('request')->request->get('exercise');

        //Get the lock category
        $user = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $Locker = $this->getDoctrine()->getManager()->getRepository('UJMExoBundle:Category')->getCategoryLocker($user);
        if (empty($Locker)) {
            $catLocker = "";
        } else {
            $catLocker = $Locker[0];
        }

        $exercise = $this->getDoctrine()->getManager()->getRepository('UJMExoBundle:Exercise')->find($exoID);
        $formHandler = new InteractionQCMHandler(
            $form, $this->get('request'), $this->getDoctrine()->getManager(),
            $this->container->get('ujm.exo_exercise'),
            $this->container->get('security.token_storage')->getToken()->getUser(), $exercise,
            $this->get('translator')
        );

        $qcmHandler = $formHandler->processAdd();
        if ($qcmHandler === TRUE) {
            $categoryToFind = $interQCM->getInteraction()->getQuestion()->getCategory();
            $titleToFind = $interQCM->getInteraction()->getQuestion()->getTitle();

            if ($exoID == -1) {
                return $this->redirect(
                    $this->generateUrl('ujm_question_index', array(
                        'categoryToFind' => base64_encode($categoryToFind), 'titleToFind' => base64_encode($titleToFind))
                    )
                );
            } else {
                return $this->redirect(
                    $this->generateUrl('ujm_exercise_questions', array(
                        'id' => $exoID, 'categoryToFind' => $categoryToFind, 'titleToFind' => $titleToFind)
                    )
                );
            }
        }

        if ($qcmHandler == 'infoDuplicateQuestion') {
            $form->addError(new FormError(
                    $this->get('translator')->trans('infoDuplicateQuestion')
                    ));
        }

        $typeQCM = $services->getTypeQCM();
        $formWithError = $this->render(
            'UJMExoBundle:InteractionQCM:new.html.twig', array(
            'entity' => $interQCM,
            'form'   => $form->createView(),
            'error'  => true,
            'exoID'  => $exoID,
            'typeQCM' => json_encode($typeQCM)
            )
        );

        $formWithError = substr($formWithError, strrpos($formWithError, 'GMT') + 3);

        return $this->render(
            'UJMExoBundle:Question:new.html.twig', array(
            'formWithError' => $formWithError,
            'exoID'  => $exoID,
            'linkedCategory' =>  $this->container->get('ujm.exo_question')->getLinkedCategories(),
            'locker' => $catLocker
            )
        );
    }

    /**
     *
     * @access public
     *
     * Forwarded by 'UJMExoBundle:Question:edit'
     * Parameters posted :
     *     \UJM\ExoBundle\Entity\Interaction interaction
     *     integer exoID
     *     integer catID
     *     \Claroline\CoreBundle\Entity\User user
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction()
    {
        $attr = $this->get('request')->attributes;
        $qcmSer  = $this->container->get('ujm.exo_InteractionQCM');
        $questSer = $this->container->get('ujm.exo_question');
        $catSer = $this->container->get('ujm.exo_category');
        $em = $this->get('doctrine')->getEntityManager();

        $interactionQCM = $em->getRepository('UJMExoBundle:InteractionQCM')
                             ->getInteractionQCM($attr->get('interaction')->getId());
        //fired a sort function
        $interactionQCM->sortChoices();

        $editForm = $this->createForm(
            new InteractionQCMType(
        $attr->get('user'), $attr->get('catID')), $interactionQCM
        );

        $typeQCM = $qcmSer->getTypeQCM();
        $linkedCategory = $questSer->getLinkedCategories();

        $vars['entity']         = $interactionQCM;
        $vars['edit_form']      = $editForm->createView();
        $vars['nbResponses']    = $qcmSer->getNbReponses($attr->get('interaction'));
        $vars['linkedCategory'] = $linkedCategory;
        $vars['typeQCM'       ] = json_encode($typeQCM);
        $vars['exoID']          = $attr->get('exoID');
        $vars['locker']         = $catSer->getLockCategory();

        if ($attr->get('exoID') != -1) {
            $exercise = $em->getRepository('UJMExoBundle:Exercise')->find($attr->get('exoID'));
            $vars['_resource'] = $exercise;
        }

        return $this->render('UJMExoBundle:InteractionQCM:edit.html.twig', $vars);
   }

    /**
     * Edits an existing InteractionQCM entity.
     *
     * @access public
     *
     * @param integer $id id of InteractionQCM
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction($id)
    {
        $exoID = $this->container->get('request')->request->get('exercise');
        $user  = $this->container->get('security.token_storage')->getToken()->getUser();
        $catID = -1;

        $em = $this->getDoctrine()->getManager();

        $interQCM = $em->getRepository('UJMExoBundle:InteractionQCM')->find($id);

        if (!$interQCM) {
            throw $this->createNotFoundException('Unable to find InteractionQCM entity.');
        }

        if ($user->getId() != $interQCM->getInteraction()->getQuestion()->getUser()->getId()) {
            $catID = $interQCM->getInteraction()->getQuestion()->getCategory()->getId();
        }

        $editForm   = $this->createForm(
            new InteractionQCMType(
                $this->container->get('security.token_storage')->getToken()->getUser(),
                $catID
            ), $interQCM
        );
        $formHandler = new InteractionQCMHandler(
            $editForm, $this->get('request'), $this->getDoctrine()->getManager(),
            $this->container->get('ujm.exo_exercise'),
            $this->container->get('security.token_storage')->getToken()->getUser(),
            $this->get('translator')
        );

        if ($formHandler->processUpdate($interQCM)) {
            if ($exoID == -1) {

                return $this->redirect($this->generateUrl('ujm_question_index'));
            } else {

                return $this->redirect(
                    $this->generateUrl(
                        'ujm_exercise_questions',
                        array(
                            'id' => $exoID,
                        )
                    )
                );
            }
        }

        return $this->forward(
            'UJMExoBundle:Question:edit', array(
                'exoID' => $exoID,
                'id'    => $interQCM->getInteraction()->getQuestion()->getId(),
                'form'  => $editForm
            )
        );
    }

    /**
     * Deletes a InteractionQCM entity.
     *
     * @access public
     *
     * @param integer $id id of InteractionQCM
     * @param intger $pageNow for pagination, actual page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($id, $pageNow)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UJMExoBundle:InteractionQCM')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find InteractionQCM entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('ujm_question_index', array('pageNow' => $pageNow)));
    }

    /**
     * To test the QCM by the teacher
     *
     * @access public
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function responseQcmAction()
    {
        $vars = array();
        $request = $this->get('request');
        $postVal = $req = $request->request->all();

        if ($postVal['exoID'] != -1) {
            $exercise = $this->getDoctrine()->getManager()->getRepository('UJMExoBundle:Exercise')->find($postVal['exoID']);
            $vars['_resource'] = $exercise;
        }

        $interQcmSer = $this->container->get('ujm.exo_InteractionQCM');
        $res = $interQcmSer->response($request);

        $vars['score']    = $res['score'];
        $vars['penalty']  = $res['penalty'];
        $vars['interQCM'] = $res['interQCM'];
        $vars['response'] = $res['response'];
        $vars['exoID']    = $postVal['exoID'];

        return $this->render('UJMExoBundle:InteractionQCM:qcmOverview.html.twig', $vars);
    }

}
