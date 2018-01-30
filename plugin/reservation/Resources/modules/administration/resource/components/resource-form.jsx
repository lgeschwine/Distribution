import React from 'react'
import {PropTypes as T} from 'prop-types'
import {connect} from 'react-redux'

import {trans} from '#/main/core/translation'
import {FormContainer} from '#/main/core/data/form/containers/form.jsx'
import {select as formSelect} from '#/main/core/data/form/selectors'

const Resource = props =>
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

Resource.propTypes = {
  new: T.bool.isRequired
}

const ResourceForm = connect(
  state => ({
    new: formSelect.isNew(formSelect.form(state, 'resourceForm'))
  })
)(Resource)

export {
  ResourceForm
}
