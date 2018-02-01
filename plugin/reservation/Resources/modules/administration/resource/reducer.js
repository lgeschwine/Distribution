import {makeFormReducer} from '#/main/core/data/form/reducer'
import {makeListReducer} from '#/main/core/data/list/reducer'

const reducer = {
  resources: makeListReducer('resources', {}, {}),
  resourceForm: makeFormReducer('resourceForm', {}, {
    organizations: makeListReducer('resourceForm.organizations')
  }),
  organizationsPicker: makeListReducer('organizationsPicker')
}

export {
  reducer
}
