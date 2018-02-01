import {makePageReducer} from '#/main/core/layout/page/reducer'

import {reducer as resourceReducer} from '#/plugin/reservation/administration/resource/reducer'
import {reducer as resourceTypeReducer} from '#/plugin/reservation/administration/resource-type/reducer'

const reducer = makePageReducer({}, {
  resources: resourceReducer.resources,
  resourceForm: resourceReducer.resourceForm,
  organizationsPicker: resourceReducer.organizationsPicker,
  resourceTypes: resourceTypeReducer.resourceTypes
})

export {
  reducer
}
