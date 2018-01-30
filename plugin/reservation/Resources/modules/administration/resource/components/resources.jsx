import React from 'react'
import {PropTypes as T} from 'prop-types'

import {trans} from '#/main/core/translation'
import {DataListContainer} from '#/main/core/data/list/containers/data-list.jsx'

const Resources = () =>
  <DataListContainer
    name="resources"
    fetch={{
      url: ['apiv2_reservationresource_list'],
      autoload: true
    }}
    delete={{
      url: ['apiv2_reservationresource_delete_bulk']
    }}
    definition={[{
      name: 'name',
      label: trans('name', {}, 'platform'),
      type: 'string',
      displayed: true
    }, {
      name: 'resourceType.name',
      label: trans('type', {}, 'platform'),
      type: 'string',
      displayed: true
    }, {
      name: 'localisation',
      label: trans('location', {}, 'platform'),
      type: 'string',
      displayed: true
    }, {
      name: 'quantity',
      label: trans('quantity', {}, 'reservation'),
      type: 'number',
      displayed: true
    }, {
      name: 'color',
      label: trans('color', {}, 'platform'),
      type: 'string',
      displayed: true
    }]}
    filterColumns={true}
    actions={[]}
    card={() => ({
      onClick: () => {},
      poster: null,
      icon: null,
      title: '',
      subtitle: '',
      contentText: '',
      flags: [].filter(flag => !!flag),
      footer:
        <span></span>,
      footerLong:
        <span></span>
    })}
  />

export {
  Resources
}
