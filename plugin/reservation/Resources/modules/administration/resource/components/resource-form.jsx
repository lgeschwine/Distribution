import React from 'react'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'

import {trans} from '#/main/core/translation'
import {FormContainer} from '#/main/core/data/form/containers/form.jsx'
import {select as formSelect} from '#/main/core/data/form/selectors'

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
              type: 'text',
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
    />
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
    resourceTypes: state.resourceTypes
  })
)(Resource)

export {
  ResourceForm
}
