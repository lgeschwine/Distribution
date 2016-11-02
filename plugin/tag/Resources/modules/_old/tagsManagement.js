import modal from '#/main/core/_old/modal'
import './tagTypeahead'

import $ from 'jquery'

/* global Routing */
/* global Translator */

$('#tags-display-box').on('click', '.remove-tag-from-object-btn', function () {
  // var taggedObjectId = $(this).data('tagged-object-id')
  var resourceId = $(this).closest('.tag-element').data('resource-id')
  var tagId = $(this).closest('.tag-element').data('tag-id')
  modal.confirmRequest(
    Routing.generate(
      'claro_tag_resource_tag_delete',
      {'resourceNode': resourceId, 'tag': tagId}
    ),
    removeTaggedObjectRow,
    tagId,
    Translator.trans('remove_tag_from_object_message', {}, 'tag'),
    Translator.trans('remove_tag', {}, 'tag')
  )
})

var removeTaggedObjectRow = function (event, tagId) {
  $('.tag-element[data-tag-id="' + tagId + '"]').remove()
}
