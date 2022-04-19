

@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template as Template;
$formInputAttr = config('phon.template.form_input');
$formLabelAttr = config('phon.template.form_label_edit');
$levelValue = ['default'=> 'Select level', 'admin' => config('phon.template.level.admin.name'), 'member' => config('phon.template.level.member.name')];


$inputHiddenID = Form::hidden('id', $item['id']?? null);
$inputHiddenTask = Form::hidden('task','change-level');

$elements = [
    [
        'label' =>  Form::label('level', 'Level', $formLabelAttr),
        'element' => Form::select('level', $levelValue, $item['level']?? null, $formInputAttr)
    ],
    [
        'element' =>  $inputHiddenID.   $inputHiddenTask. Form::submit('Save', ['class' => 'btn btn-success']),
        'type' => 'btn submit edit'
    ],
]
@endphp

<div class="col-md-6 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        @include('admin.templates.x_title', ['title'=> 'Quyền truy cập'])
        {!! Form::open([
            'method'        => 'POST', 
            'url'           => route("$prefix/save"),
            'accept-charset'=> 'UTF-8',
            'class'         => 'form-horizontal form-label-left',
            'id'            => 'main-form' ]) !!}
            {!! FormTemplate::show($elements) !!}
        {!! Form::close() !!}
    </div>
</div>