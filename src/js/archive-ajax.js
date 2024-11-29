function getArchivePage(params) {
  const data = {
    action: 'ubc_vpfo_get_archive_page',
    _nonce: archive_ajax_params._nonce,
    params: params
  }

  return $.ajax({
    url: archive_ajax_params.ajax_url,
    type: 'POST',
    data: data,
  });
}

function getFilterParams(form) {
  let $form = $(form);

  return {
    'post_type': $form.find('input[name="post_type"]').val(),
    'category' : $form.find('.cat-tax-select select').val(),
    'search'   : $form.find('input[name="s"]').val(),
    'page'     : 0, // To be modified outside of this fn.
  }
}

document.addEventListener('DOMContentLoaded', function () {
  $('.archive-filter-form').submit(async (e) => {
    e.preventDefault();

    const params = getFilterParams(e.target);
    const res = await getArchivePage(params);

    console.log(res);
    
    // $.ajax({
    //   url: $('#form').attr('action'),
    //   type: 'POST',
    //   data : $('#form').serialize(),
    //   success: function(){
    //     console.log('form submitted.');
    //   }
    // });
    // return false;
  });
});
