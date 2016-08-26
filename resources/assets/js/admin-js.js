jQuery(document).ready(function($) {
    function momentAll() {
        $('.momentMe').each(function(index, element) {
            var expiration = jQuery(element).text();
            expiration = moment.unix(parseInt(expiration));
            jQuery(element).text(expiration.format('LLL'));
        });
    }

    function initValidation() {
        var form = $('form.needs-validation').data('formValidation');

        if(typeof(form) != 'undefined') {
            form.destroy();    
        }
        $('form.needs-validation').formValidation({
            framework: 'bootstrap',
            icon: {
                valid: null,
                invalid: null,
                validating: null
            }
        });
    }
    function validateForm() {
        var toValidate = $('form.needs-validation').data('formValidation').validate();
        return toValidate.isValid();
    }

    // instantiate switches, colorpickers, tooltips, moment formating, clipboard button, etc.
    $("[type='checkbox']").bootstrapSwitch();
    $("[type='color']").ColorPicker();
    $('[data-toggle="tooltip"]').tooltip();
    momentAll();
    new Clipboard('.btn.fa.fa-link');

    $('.select2').select2({
        width: "100%",
    });

    var remodal = $('[data-remodal-id=remodal-modal]').remodal({closeOnConfirm: false});

    $(document).on('click', '#users-modal-toggle', function(event) {
        event.preventDefault();
        $.get( "/SecureCredentials/userCreate/get", function( data ) {
            $('.remodal:first').find('#modal-content').html(data);
        }).done(function() {
            initValidation();
            remodal.open();
        });
    });

    $(document).on('confirmation', '#users-modal.remodal', function() {
        var subData = $("form#users-form").serializeArray();       
        var isDelete = false;
        var isUpdate = false;
        for(var key in subData) {
            if(subData[key].name == 'id') {
              isDelete = true;
            } else if(subData[key].name == 'update') {
                isUpdate = true;
            }
        }
        var route;
        
        if(isDelete) {
            route = '/SecureCredentials/userDelete/post';
        } else if(isUpdate) {
            route = '/SecureCredentials/userUpdate/post';
        } else {
            route = '/SecureCredentials/userCreate/post';
        }

        if(validateForm()) {
            $.post( route, subData, function( data ) {
                $('.loading').show();
                $('#users-body').hide();
                $.get( "/SecureCredentials/users/get", function( data ) {
                    $('#users-body').html(data).show();
                }).done(function() {
                    $('.loading').hide();
                });
            });
            remodal.close();
        } else {
            remodal.open();
        }
    });

    $(document).on('click', '.delete-modal-toggle', function(event) {
        event.preventDefault();
        var route;
        if($(event.target).is('a')) {
            route = $(event.target).attr('href');
        } else {
            route = $(event.target).parent().attr('href');
        }

        $.get(route, function( data ) {
            $('.remodal:first').find('#modal-content').html(data);
            remodal.open();
        }).done(function() {
            initValidation();
        });
    });

    $(document).on('click', '.edit-modal-toggle', function(event) {
        event.preventDefault();
        var route;
        if($(event.target).is('a')) {
            route = $(event.target).attr('href');
        } else {
            route = $(event.target).parent().attr('href');
        }

        $.get(route, function( data ) {
            $('.remodal:first').find('#modal-content').html(data);
        }).done(function() {
            $('#modal-content').find('.select2').select2({ width: '100%'});
            $('#strong-password').pwstrength({
                ui: {
                    showVerdictsInsideProgressBar: true
                }
            });
            initValidation();
            $('#clock').each(function(index, element) {
                var expiration = $(element).text();
                expiration = moment.unix(parseInt(expiration));
                $(element).text(expiration.format('LLL'));
            });
            initValidation();
            remodal.open();
        });
    });

    $(document).on('click', '.credential-modal-toggle', function(event) {
        event.preventDefault();
        var route = $(event.target).parent().attr('href');
        
        $.get( route, function( data ) {
            $('.remodal').find('#modal-content').html(data);
            remodal.open();
        }).done(function() {
            momentAll();
        });
            // $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).on('click', '.revoke-access', function(event) {
        event.preventDefault();
        var route;
        if($(event.target).is('a')) {
            route = $(event.target).attr('href');
        } else {
            route = $(event.target).parent().attr('href');
        }

        $.post(route, function( data ) {
            $('.remodal').find('#modal-content').html(data);
        }).done(function() {
            momentAll();
            $('[data-toggle="tooltip"]').tooltip();
        });
    });

    $(document).on('click', '#credentials-modal-toggle', function(event) {
        event.preventDefault();
        $.get( '/SecureCredentials/credentialCreate/get', function( data ) {
            $('#credentials-modal').find('#modal-content').html(data);
            remodal.open();
        }).done(function() {
            initValidation();
            $('#modal-content').find('.select2').select2({ width: '100%'});
            $('#strong-password').pwstrength({
                ui: {
                    showVerdictsInsideProgressBar: true
                }
            });
        });
    });

     $(document).on('confirmation', '#credentials-modal.remodal', function() {
        var subData = $("form#credentials-form").serializeArray();
        var isDelete = false;
        var isUpdate = false;
        var route;
        
        for(var key in subData) {
            if(subData[key].name == 'id') {
              isDelete = true;
            } else if(subData[key].name == 'update') {
                isUpdate = true;
            }
        }
        
        if(isDelete) {
            route = '/SecureCredentials/credentialDelete/post';
        } else if(isUpdate) {
            route = '/SecureCredentials/credentialUpdate/post';
        } else {
            route = '/SecureCredentials/credentialCreate/post';
        }

        if(validateForm()) {
            $.post( route, subData, function( data ) {
                $('.loading').show();
                $('#credentials-body').hide();
                $.get( "/SecureCredentials/credentials/get", function( data ) {
                    $('#credentials-body').html(data).show();
                }).done(function() {
                    $('.loading').hide();
                    momentAll();
                    initValidation();
                });
            });
            remodal.close();
        } else {
            remodal.open();
        }
    });
});

