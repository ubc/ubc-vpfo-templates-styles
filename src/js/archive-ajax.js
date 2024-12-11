function getArchivePage(params) {
  const data = {
    action: 'ubc_vpfo_get_archive_page',
    _nonce: archive_ajax_params._nonce,
    params: params
  }

  return jQuery.ajax({
    url: archive_ajax_params.ajax_url,
    type: 'POST',
    data: data,
  });
}

function getFilterParams(form) {
  const $form = jQuery(form);

  return {
    'post_type': $form.find('input[name="post_type"]').val(),
    'category' : $form.find('.cat-tax-select select').val(),
    'search'   : $form.find('input[name="s"]').val(),
    'page'     : 0, // To be modified outside of this fn.
  }
}

function handleScrollToTop(form) {
  const $form = jQuery(form);
  const $archive = $form.closest('.archive');

  if ( $archive ) {
    $archive[0].scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    });
  }
}

function initPagination(form) {
  const $form = jQuery(form);
  // console.log($form, $form.closest('.archive'), $form.closest('.archive').find('.pagination a'));

  $form.closest('.archive').find('.pagination a').click(async (e) => {
    // Get the href of the clicked pagination link
    const href = jQuery(e.target).attr('href');

    // Extract the page number using a regular expression
    const pageMatch = href.match(/\/page\/(\d+)/);
    const pageNumber = pageMatch ? parseInt(pageMatch[1], 10) : 1; // Default to 1 if no match

    if ( ! pageNumber ) {
      return;
    }

    e.preventDefault();

    // Call your functions
    const params = getFilterParams($form); // Replace with your implementation
    params.page = pageNumber;

    const res = await getArchivePage(params);

    handleNewPage(res);
  });
}

function handleNewPage(res) {
  if ( res.success ) {
    jQuery('.card-container').html(res.data.results);
    jQuery('.card-container').append(res.data.pagination);

    // Initial pagination handler setup.
    $form = jQuery('.archive-filter-form');
    if ( $form ) {
      initPagination($form[0]);

      handleScrollToTop($form[0]);
    }
  } else {
    console.error('Failed to retrieve archive page');
  }
}

document.addEventListener('DOMContentLoaded', function () {
  $form = jQuery('.archive-filter-form');

  if ( $form.length === 0 ) {
    return;
  }

  // Handle submit button.
  $form.submit(async (e) => {
    e.preventDefault();

    const params = getFilterParams($form[0]);
    const res = await getArchivePage(params);
    handleNewPage(res);
  });

  // Handle reset button.
  $form.find('button[type="reset"]').click(async (e) => {
    e.preventDefault();

    $form.find('input[name="post_type"]');

    // Reset actual form inputs.
    $form[0].reset();

    // Remove fake html representation of select.
    $form.find('.cat-tax-selected-items').html('');

    const params = getFilterParams($form[0]);
    const res = await getArchivePage(params);
    handleNewPage(res);
  });
  
  // Initial pagination handler setup.
  initPagination($form[0]);
});
