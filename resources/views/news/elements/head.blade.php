@php
    use App\Models\CategoryModel;
    $categoryModel = new CategoryModel();
    $items = $categoryModel->listItems(null, ['task' => 'new-list-items']);

    $categoryNameCurrent = Route::input('category_name');
    $categoryName = "";
    foreach ($items as $item){
        if(Str::slug($item['name']) == $categoryNameCurrent)  $categoryName = "- " . $item['name'];
    }
@endphp
<title>PDDIM {{ $categoryName}}</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Thông tin mới nhất, Việt Nam, nhanh nhất ">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link type="image/x-icon" href="{{asset('news/images/favicon1.png')}}" rel="icon" >
<link rel="stylesheet" type="text/css" href="{{asset('news/css/bootstrap-4.1.2/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/font-awesome-4.7.0/css/font-awesome.min.css')}}" >
<link rel="stylesheet" type="text/css" href="{{asset('news/js/OwlCarousel2-2.2.1/owl.carousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/js/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/js/OwlCarousel2-2.2.1/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/main_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/responsive.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('news/css/my-style.css')}}"> 
