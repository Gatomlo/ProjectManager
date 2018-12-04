var $collectionHolder;

// setup an "add a tag" link
var $newLinkLi = $('<ul></ul>')

jQuery(document).ready(function() {
  // Get the ul that holds the collection of tags
  $collectionHolder = $('ul.tags');

  $oneLi =   $collectionHolder.find('li');

  $oneLi.children().addClass('input-group');

  $oneLi.children().each(function() {
    addTagFormDeleteLink($(this));
  });

  // add the "add a tag" anchor and li to the tags ul
  $collectionHolder.append($newLinkLi);

  // count the current form inputs we have (e.g. 2), use that as the new
  // index when inserting a new item (e.g. 2)
  $collectionHolder.data('index', $collectionHolder.find(':input').length);

  $('#addTagButton').click(function(e) {
      // add a new tag form (see next code block)
      addTagForm($collectionHolder, $newLinkLi);
  });
});

function addTagForm($collectionHolder, $newLinkLi) {
  // Get the data-prototype explained earlier
  var prototype = $collectionHolder.data('prototype');

  // get the new index
  var index = $collectionHolder.data('index');

  var newForm = prototype;
  // You need this only if you didn't set 'label' => false in your tags field in TaskType
  // Replace '__name__label__' in the prototype's HTML to
  // instead be a number based on how many items we have
  // newForm = newForm.replace(/__name__label__/g, index);

  // Replace '__name__' in the prototype's HTML to
  // instead be a number based on how many items we have
  newForm = newForm.replace(/__name__/g, index);

  // increase the index with one for the next item
  $collectionHolder.data('index', index + 1);

  var $removeFormButton =  $('<div class="input-group-append"><button class="btn btn-outline-secondary" type="button">Delete this tag</button></div');

  // Display the form in the page in an li, before the "Add a tag" link li

  var $newFormLi = $('<li></li>').append(newForm);
  $newFormLi.children().children().addClass('input-group');
  addTagFormDeleteLink($newFormLi.children().children());
  $newLinkLi.before($newFormLi);

}

function addTagFormDeleteLink($tagFormLi) {
  var $removeFormButton =  $('<div class="input-group-append"><button type="button" class="btn btn-outline-secondary"><i class="fas fa-trash-alt"></i></button></div');
  $tagFormLi.append($removeFormButton);

  $removeFormButton.on('click', function(e) {
      // remove the li for the tag form
      $tagFormLi.parents('li').remove();
  });
}
