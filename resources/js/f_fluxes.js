$.ajax({
    url: $('meta[name="app-url"]').attr('content')+`/f_beneficiaries/getDataAutocomplete`,
    type: 'GET',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
    success: function(response) {
        autocomplete("f_beneficiary", response, "Buscar...")
    },error: function(xhr, textStatus, errorThrown) {
        errorMessage(xhr.status, errorThrown)
    }
});