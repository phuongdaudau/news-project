

@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    $formInputAttr = config('phon.template.form_input');
    $formLabelAttr = config('phon.template.form_label_edit');

    $inputHiddenID = Form::hidden('id', $item['id']?? null);
    $inputHiddenTask = Form::hidden('task','change-password');

    $elements = [
        [
            'label' =>  Form::label('password', 'Password', $formLabelAttr),
            'element' => Form::password('password', $formInputAttr)
        ],
        [
            'label' =>  Form::label('password_confirmation', 'Password Confirmation', $formLabelAttr),
            'element' => Form::password('password_confirmation', $formInputAttr)
        ],
        [
            'element' =>  $inputHiddenID.  $inputHiddenTask. Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => 'btn submit edit'
        ],
    ]
@endphp
<div class="col-md-6 col-sm-12 col-xs-12"> 
    <div class="x_panel">
        @include('admin.templates.x_title', ['title'=> 'Thay đổi mật khẩu'])
        {!! Form::open([
            'method'        => 'POST', 
            'url'           => route("$prefix/change-password"),
            'accept-charset'=> 'UTF-8',
            'class'         => 'form-horizontal form-label-left',
            'id'            => 'main-form' ]) !!}
            {!! FormTemplate::show($elements) !!}
        {!! Form::close() !!}
    </div>
</div>