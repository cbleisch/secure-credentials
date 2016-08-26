<?php namespace SecureCredentials;

/** @var \Herbert\Framework\Enqueue $enqueue */

$enqueue->front([
    'as'  => 'font-awesome',
    'src' => '//use.fontawesome.com/507e063452.js'
]);

$enqueue->admin([
    'as'  => 'font-awesome',
    'src' => '//use.fontawesome.com/507e063452.js'
]);

$enqueue->admin([
    'as'  => 'bootstrap-css',
    'src' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css',
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'bootstrap-js',
    'src' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js',
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'bootstrap-switch-css',
    'src' =>  Helper::assetUrl('/css/bootstrap-switch.min.css'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'bootstrap-switch-js',
    'src' =>  Helper::assetUrl('/js/bootstrap-switch.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'sc-js',
    'src' =>  Helper::assetUrl('/js/admin-js.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'admin-css',
    'src' =>  Helper::assetUrl('/css/admin-style.css'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'select2-css',
    'src' =>  '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css',
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'select2-js',
    'src' =>  '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'colorpicker-css',
    'src' =>  Helper::assetUrl('/css/colorpicker.css'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'colorpicker-js',
    'src' =>  Helper::assetUrl('/js/colorpicker.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'remodal-css',
    'src' =>  Helper::assetUrl('/css/remodal.css'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'remodal-theme-css',
    'src' =>  Helper::assetUrl('/css/remodal-default-theme.css'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'remodal-js',
    'src' =>  Helper::assetUrl('/js/remodal.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

// $enqueue->admin([
//     'as'  => 'strength-css',
//     'src' =>  Helper::assetUrl('/css/strength.css'),
//     'filter' => [ 'panel' => '*' ]
// ]);

$enqueue->admin([
    'as'  => 'pwstrength-js',
    'src' =>  Helper::assetUrl('/js/pwstrength-bootstrap.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'moment-js',
    'src' =>  Helper::assetUrl('/bower_components/moment/min/moment.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'clipboard-js',
    'src' =>  Helper::assetUrl('/bower_components/clipboard/dist/clipboard.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'countdown-js',
    'src' =>  Helper::assetUrl('/bower_components/jquery.countdown/dist/jquery.countdown.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'form-validation-js',
    'src' =>  Helper::assetUrl('/js/formValidation.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'form-validation-popular-js',
    'src' =>  Helper::assetUrl('/js/formValidation.popular.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'form-validation-bootstrap-framework-js',
    'src' =>  Helper::assetUrl('/js/fv.bootstrap.min.js'),
    'filter' => [ 'panel' => '*' ]
]);

$enqueue->admin([
    'as'  => 'form-validation-css',
    'src' =>  Helper::assetUrl('/css/formValidation.min.css'),
    'filter' => [ 'panel' => '*' ]
]);

// $enqueue->admin([
//     'as'  => 'loading-gif',
//     'src' =>  Helper::assetUrl('/img/preloader.gif'),
//     'filter' => [ 'panel' => '*' ]
// ]);