import {bootstrap} from '#/main/core/scaffolding/bootstrap'

import {reducer} from '#/plugin/reservation/administration/resource/reducer'
import {ReservationTool} from '#/plugin/reservation/administration/resource/components/tool.jsx'

// mount the react application
bootstrap(
  // app DOM container (also holds initial app data as data attributes)
  '.reservation-tool-container',

  // app main component (accepts either a `routedApp` or a `ReactComponent`)
  ReservationTool,

  // app store configuration
  reducer
)