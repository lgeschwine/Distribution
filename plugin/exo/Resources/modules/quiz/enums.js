import {tex} from '#/main/core/translation'

// TODO : migrate select options formats

export const TYPE_QUIZ = 'quiz'
export const TYPE_STEP = 'step'

export const QUIZ_SUMMATIVE = 'summative'
export const QUIZ_EVALUATIVE = 'evaluative'
export const QUIZ_FORMATIVE = 'formative'

export const quizTypes = [
  [QUIZ_SUMMATIVE, 'summative'],
  [QUIZ_EVALUATIVE, 'evaluative'],
  [QUIZ_FORMATIVE, 'formative']
]

export const QUIZ_PICKING_DEFAULT = 'standard'
export const QUIZ_PICKING_TAGS = 'tags'

export const quizPicking = {
  [QUIZ_PICKING_DEFAULT]: tex('quiz_picking_steps'),
  [QUIZ_PICKING_TAGS]: tex('quiz_picking_tags')
}

export const NUMBERING_NONE = 'none'
export const NUMBERING_LITTERAL = 'litteral'
export const NUMBERING_NUMERIC = 'numeric'

export const quizNumbering = [
  [NUMBERING_NONE, 'none'],
  [NUMBERING_LITTERAL, 'litteral'],
  [NUMBERING_NUMERIC, 'numeric']
]

export const VIEW_OVERVIEW = 'overview'
export const VIEW_PLAYER = 'player'
export const VIEW_EDITOR = 'editor'
export const VIEW_PAPERS = 'papers'
export const VIEW_PAPER = 'paper'
export const VIEW_CORRECTION_QUESTIONS = 'correction_questions'
export const VIEW_CORRECTION_ANSWERS = 'correction_answers'
export const VIEW_ATTEMPT_END = 'attempt_end'
export const VIEW_STATISTICS = 'view_statistics'

export const viewModes = [
  [VIEW_OVERVIEW, 'overview'],
  [VIEW_PLAYER, 'player'],
  [VIEW_EDITOR, 'editor'],
  [VIEW_PAPERS, 'papers'],
  [VIEW_PAPER, 'paper'],
  [VIEW_CORRECTION_QUESTIONS, 'correction_questions'],
  [VIEW_CORRECTION_ANSWERS, 'correction_answers']
]

export const SHUFFLE_NEVER = 'never'
export const SHUFFLE_ALWAYS = 'always'
export const SHUFFLE_ONCE = 'once'

export const shuffleModes = [
  {value: SHUFFLE_NEVER,  label: tex('never')},
  {value: SHUFFLE_ALWAYS, label: tex('at_each_attempt')},
  {value: SHUFFLE_ONCE,   label: tex('at_first_attempt')}
]

export const SHOW_CORRECTION_AT_VALIDATION = 'validation'
export const SHOW_CORRECTION_AT_LAST_ATTEMPT = 'lastAttempt'
export const SHOW_CORRECTION_AT_DATE = 'date'
export const SHOW_CORRECTION_AT_NEVER = 'never'

export const correctionModes = [
  [SHOW_CORRECTION_AT_VALIDATION, 'at_the_end_of_assessment'],
  [SHOW_CORRECTION_AT_LAST_ATTEMPT, 'after_the_last_attempt'],
  [SHOW_CORRECTION_AT_DATE, 'from'],
  [SHOW_CORRECTION_AT_NEVER, 'never']
]

export const SHOW_SCORE_AT_CORRECTION = 'correction'
export const SHOW_SCORE_AT_VALIDATION = 'validation'
export const SHOW_SCORE_AT_NEVER = 'never'

export const markModes = [
  [SHOW_SCORE_AT_CORRECTION, 'at_the_same_time_that_the_correction'],
  [SHOW_SCORE_AT_VALIDATION, 'at_the_end_of_assessment'],
  [SHOW_SCORE_AT_NEVER, 'never']
]

export const SCORE_SUM = 'sum'
export const SCORE_FIXED = 'fixed'
export const SCORE_MANUAL = 'manual'

export const TOTAL_SCORE_ON_DEFAULT = 'default'
export const TOTAL_SCORE_ON_CUSTOM = 'custom'

export const STATISTICS_ALL_PAPERS = 'default'
export const STATISTICS_FINISHED_PAPERS_ONLY = 'custom'

export const statisticsModes = [
  [STATISTICS_ALL_PAPERS, 'compute_from_all_papers'],
  [STATISTICS_FINISHED_PAPERS_ONLY, 'compute_from_finished_papers_only']
]
