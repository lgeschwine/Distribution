import {makeFormReducer} from '#/main/core/data/form/reducer'
import {makeListReducer} from '#/main/core/data/list/reducer'

const reducer = {
  resources: makeListReducer('resources', {}, {}),
  resourceForm: makeFormReducer('resourceForm')
}

export {
  reducer
}
