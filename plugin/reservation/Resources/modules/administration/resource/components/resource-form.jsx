import React from 'react'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'

import {trans} from '#/main/core/translation'
import {select as formSelect} from '#/main/core/data/form/selectors'
import {actions as modalActions} from '#/main/core/layout/modal/actions'
import {MODAL_DATA_PICKER} from '#/main/core/data/list/modals'
import {FormContainer} from '#/main/core/data/form/containers/form.jsx'
import {FormSections, FormSection} from '#/main/core/layout/form/components/form-sections.jsx'
import {DataListContainer} from '#/main/core/data/list/containers/data-list.jsx'
import {OrganizationList} from '#/main/core/administration/user/organization/components/organization-list.jsx'

import {actions} from '#/plugin/reservation/administration/resource/actions'

const Resource = props => {
  const choices = {}
  props.resourceTypes.reduce((o, rt) => Object.assign(o, {[rt.id]: rt.name}), choices)

  return (
    <FormContainer
      level={2}
      name="resourceForm"
      sections={[
        {
          id: 'general',
          title: trans('general', {}, 'platform'),
          primary: true,
          fields: [
            {
              name: 'name',
              type: 'string',
              label: trans('name', {}, 'platform'),
              required: true
            }, {
              name: 'resourceType.id',
              type: 'enum',
              label: trans('type', {}, 'platform'),
              required: true,
              options: {
                choices: choices
              }
            }, {
              name: 'description',
              type: 'html',
              label: trans('description', {}, 'platform')
            }, {
              name: 'localisation',
              type: 'string',
              label: trans('location', {}, 'platform')
            }, {
              name: 'quantity',
              type: 'number',
              label: trans('quantity', {}, 'reservation'),
              required: true,
              options: {
                min: 1
              }
            }, {
              name: 'color',
              type: 'color-picker',
              label: trans('color', {}, 'platform')
            }
          ]
        }
      ]}
    >
      <FormSections level={3}>
        <FormSection
          id="resource-organizations"
          icon="fa fa-fw fa-building"
          title={trans('organizations', {}, 'platform')}
          disabled={props.new}
          actions={[
            {
              icon: 'fa fa-fw fa-plus',
              label: trans('add_organizations', {}, 'platform'),
              action: () => props.pickOrganizations(props.resource.id)
            }
          ]}
        >
          <DataListContainer
            name="resourceForm.organizations"
            open={OrganizationList.open}
            fetch={{
              url: ['apiv2_reservationresource_list_organizations', {id: props.resource.id}],
              autoload: props.resource.id && !props.new
            }}
            delete={{
              url: ['apiv2_reservationresource_remove_organizations', {id: props.resource.id}]
            }}
            definition={OrganizationList.definition}
            card={OrganizationList.card}
          />
        </FormSection>
      </FormSections>
    </FormContainer>
  )
}

Resource.propTypes = {
  new: T.bool.isRequired,
  resourceTypes: T.arrayOf(T.shape({
    id: T.string.isRequired,
    name: T.string.isRequired
  }))
}

const ResourceForm = connect(
  state => ({
    new: formSelect.isNew(formSelect.form(state, 'resourceForm')),
    resource: formSelect.data(formSelect.form(state, 'resourceForm')),
    resourceTypes: state.resourceTypes
  }),
  dispatch =>({
    pickOrganizations(resourceId) {
      dispatch(modalActions.showModal(MODAL_DATA_PICKER, {
        icon: 'fa fa-fw fa-buildings',
        title: trans('add_organizations', {}, 'platform'),
        confirmText: trans('add', {}, 'platform'),
        name: 'organizationsPicker',
        definition: OrganizationList.definition,
        card: OrganizationList.card,
        fetch: {
          url: ['apiv2_organization_list'],
          autoload: true
        },
        handleSelect: (selected) => dispatch(actions.addOrganizations(resourceId, selected))
      }))
    }
  })
)(Resource)

export {
  ResourceForm
}
