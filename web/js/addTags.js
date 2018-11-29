// setup an "add a tag" link
var $addTagLink = $('<button type="button" class="add_tag_link btn btn-primary"><i class="fas fa-tags"></i></button>');
var $newLinkLi = $('<span></span>').append($addTagLink);

jQuery(document).ready(function() {
  // Get the ul that holds the collection of tags
  var $collectionHolder = $('div.tags');

  // add the "add a tag" anchor and li to the tags ul
  $collectionHolder.append($newLinkLi);

  // count the current form inputs we have (e.g. 2), use that as the new
  // index when inserting a new item (e.g. 2)
  $collectionHolder.data('index', $collectionHolder.find(':input').length);

  $addTagLink.on('click', function(e) {
      // prevent the link from creating a "#" on the URL
      e.preventDefault();

      // add a new tag form (see code block below)
      addTagForm($collectionHolder, $newLinkLi);
  });


});

function addTagForm($collectionHolder, $newLinkLi) {
  // Get the data-prototype explained earlier
  var prototype = $collectionHolder.data('prototype');

  // get the new index
  var index = $collectionHolder.data('index');

  // Replace '$$name$$' in the prototype's HTML to
  // instead be a number based on how many items we have
  var newForm = prototype.replace(/__name__/g, index);

  // increase the index with one for the next item
  $collectionHolder.data('index', index + 1);

  // Display the form in the page in an li, before the "Add a tag" link li
  var $newFormLi = $('<span class="test"></span>').append(newForm).children().children().addClass('input-group').append('<div class="input-group-append"><button class="btn btn-outline-secondary remove-tag" type="button" id="button-addon2"><i class="far fa-trash-alt"></i></button></div>');

  $newLinkLi.after($newFormLi);

  // handle the removal, just for this example
  $('.remove-tag').click(function(e) {
      e.preventDefault();

      $(this).parent().parent().remove();

      return false;
  });
}
