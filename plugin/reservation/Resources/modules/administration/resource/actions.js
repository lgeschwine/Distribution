import {generateUrl} from '#/main/core/api/router'
import {API_REQUEST} from '#/main/core/api/actions'
import {actions as formActions} from '#/main/core/data/form/actions'
import {actions as listActions} from '#/main/core/data/list/actions'

export const actions = {}

actions.openForm = (formName, id = null) => (dispatch) => {
  if (id) {
    dispatch({
      [API_REQUEST]: {
        url: ['apiv2_reservationresource_get', {id}],
        success: (response, dispatch) => {
          dispatch(formActions.resetForm(formName, response, false))
        }
      }
    })
  } else {
    dispatch(formActions.resetForm(formName, {}, true))
  }
}

actions.addOrganizations = (id, organizations) => ({
  [API_REQUEST]: {
    url: generateUrl('apiv2_reservationresource_add_organizations', {id: id}) +'?'+ organizations.map(id => 'ids[]='+id).join('&'),
    request: {
      method: 'PATCH'
    },
    success: (data, dispatch) => {
      dispatch(listActions.invalidateData('resources'))
      dispatch(listActions.invalidateData('resourceForm.organizations'))
    }
  }
})