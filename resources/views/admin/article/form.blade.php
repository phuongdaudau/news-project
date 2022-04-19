
@extends('admin.main')
@php
    use App\Helpers\Form as FormTemplate;
    use App\Helpers\Template as Template;
    $formInputAttr = config('phon.template.form_input');
    $formLabelAttr = config('phon.template.form_label');
    $formCkeditor = config('phon.template.form_ckeditor');
    $statusValue = ['default'=> 'Select status', 'active' => config('phon.template.status.active.name'), 'inactive' => config('phon.template.status.inactive.name')];
    
    $inputHiddenID = Form::hidden('id', $item['id']?? null);
    $inputHiddenThumb = Form::hidden('thumb_current', $item['thumb']?? null);

    $elements = [
        [
            'label' =>  Form::label('name', 'Name', $formLabelAttr),
            'element' => Form::text('name', $item['name']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('content', 'Content', $formLabelAttr),
            'element' => Form::textArea('content', $item['content']?? null, $formCkeditor)
        ],
        [
            'label' =>  Form::label('status', 'Status', $formLabelAttr),
            'element' => Form::select('status',  $statusValue, $item['status']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('category_id', 'Category', $formLabelAttr),
            'element' => Form::select('category_id', $itemCategory, $item['category_id']?? null, $formInputAttr)
        ],
        [
            'label' =>  Form::label('thumb', 'Thumb', $formLabelAttr),
            'element' => Form::file('thumb',     $formInputAttr),
            'thumb' => (!empty($item['id']) ? Template::showItemThumb($prefix, $item['thumb'], $item['name']) : null),
            'type' => 'thumb'
        ],
        [
            'element' =>  $inputHiddenID. $inputHiddenThumb . Form::submit('Save', ['class' => 'btn btn-success']),
            'type' => 'btn submit'
        ],
    ]
@endphp
@section('content')
    @include('admin.templates.page_header', ['pageIndex'=> false])
    @include('admin.templates.error')
    <!--box-lists-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="x_panel">
                @include('admin.templates.x_title', ['title'=> 'Form'])
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
    </div>
    <!--end-box-lists-->
    
@endsection