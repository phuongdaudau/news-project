

@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    $formInputAttr = config('phon.template.form_input');
    $formLabelAttr = config('phon.template.form_label');
    $statusValue = ['default'=> 'Select status', 'active' => config('phon.template.status.active.name'), 'inactive' => config('phon.template.status.inactive.name')];
    $levelValue = ['default'=> 'Select level', 'admin' => config('phon.template.level.admin.name'), 'member' => config('phon.template.level.member.name')];


    $inputHiddenID = Form::hidden('id', $item['id']?? null);
    $inputHiddenAvatar = Form::hidden('avatar_current', $item['avatar']?? null);
    $inputHiddenTask = Form::hidden('task','add');

    $elements = [
        [
            'label' =>  Form::label('username', 'UserName', $formLabelAttr),
            'element' => Form::text('username', $item['username']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('email', 'Email', $formLabelAttr),
            'element' => Form::text('email', $item['email']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('fullname', 'Fullname', $formLabelAttr),
            'element' => Form::text('fullname', $item['fullname']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('password', 'Password', $formLabelAttr),
            'element' => Form::password('password', $formInputAttr)
        ],
        [
            'label' =>  Form::label('password_confirmation', 'Password Confirmation', $formLabelAttr),
            'element' => Form::password('password_confirmation', $formInputAttr)
        ],
        [
            'label' =>  Form::label('status', 'Status', $formLabelAttr),
            'element' => Form::select('status', $statusValue, $item['status']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('level', 'Level', $formLabelAttr),
            'element' => Form::select('level', $levelValue, $item['level']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('avatar', 'Avatar', $formLabelAttr),
            'element' => Form::file('avatar',     $formInputAttr),
            'avatar' => (!empty($item['id']) ? Template::showItemThumb($prefix, $item['avatar'], $item['name']) : null),
            'type' => 'avatar'
        ],
        [
            'element' =>  $inputHiddenID. $inputHiddenAvatar .  $inputHiddenTask. Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => 'btn submit'
        ],
    ]
@endphp
@section('content')
    @include('admin.templates.error')
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            @include('admin.templates.x_title', ['title'=> 'Form Add'])
            {!! Form::open([
                'method'        => 'POST', 
                'url'           => route("$prefix/save"),
                'accept-charset'=> 'UTF-8',
                'enctype'       => 'multipart/form-data',
                'class'         => 'form-horizontal form-label-left',
                'id'            => 'main-form' ]) !!}
                {!! FormTemplate::show($elements) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection