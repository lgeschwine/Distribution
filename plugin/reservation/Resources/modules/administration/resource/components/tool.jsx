import React from 'react'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'

import {trans} from '#/main/core/translation'
import {navigate, matchPath, Routes, withRouter} from '#/main/core/router'
import {
  PageActions,
  PageAction,
  PageContent,
  PageHeader,
  RoutedPageContainer
} from '#/main/core/layout/page'
import {FormPageActionsContainer} from '#/main/core/data/form/containers/page-actions.jsx'

import {actions} from '#/plugin/reservation/administration/resource/actions'
import {Resources} from '#/plugin/reservation/administration/resource/components/resources.jsx'
import {ResourceForm} from '#/plugin/reservation/administration/resource/components/resource-form.jsx'

const ToolActions = props =>
  <PageActions>
    <FormPageActionsContainer
      formName="resourceForm"
      target={(resource, isNew) => isNew ?
        ['apiv2_reservationresource_create'] :
        ['apiv2_reservationresource_update', {id: resource.id}]
      }
      opened={!!matchPath(props.location.pathname, {path: '/form'})}
      open={{
        icon: 'fa fa-plus',
        label: trans('create_a_resource', {}, 'reservation'),
        action: '#/form'
      }}
      cancel={{
        action: () => navigate('/')
      }}
    />
  </PageActions>

ToolActions.propTypes = {
  location: T.shape({
    pathname: T.string
  }).isRequired
}

const ToolPageActions = withRouter(ToolActions)

const Tool = props =>
  <RoutedPageContainer
    id="tool-page-container"
  >
    <PageHeader
      title={trans('admin_resources_reservation', {}, 'tools')}
      key="tool-page-header"
    >
      <ToolPageActions/>
    </PageHeader>
    <PageContent key="tool-page-content">
      <Routes
        routes={[
          {
            path: '/',
            exact: true,
            component: Resources
          }, {
            path: '/form/:id?',
            component: ResourceForm,
            onEnter: (params) => props.openForm(params.id || null)
          }
        ]}
      />
    </PageContent>
  </RoutedPageContainer>

Tool.propTypes = {
  openForm: T.func.isRequired
}

const ReservationTool = connect(
  () => ({}),
  dispatch => ({
    openForm(id = null) {
      dispatch(actions.openForm('resourceForm', id))
    }
  })
)(Tool)

export {
  ReservationTool
}