@php
    use App\Helpers\Template as Template;
    use App\Helpers\Highlight as Highlight;
@endphp
          <div class="x_content">
             <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                   <thead>
                      <tr class="headings">
                         <th class="column-title">STT</th>
                         <th class="column-title">Article Info</th>
                         <th class="column-title">Thumb</th>
                         <th class="column-title">Category</th>
                         <th class="column-title">Kiểu bài viết</th>
                         <th class="column-title">Trạng thái</th>
                         {{--<th class="column-title">Tạo mới</th>
                         <th class="column-title">Chỉnh sửa</th> --}}
                         <th class="column-title">Hành động</th>
                      </tr>
                   </thead>
                   <tbody>
                    @if (count($items) >= 1)
                        @foreach ($items as $key => $val)
                            @php
                                $index        = $key +1;
                                $id           = $val['id'];
                                $class        = ($index%2 ==0) ?"even" :"odd";
                                $name         = Highlight::show($val['name'], $params['search'], 'name');
                                $content      = Highlight::show($val['content'], $params['search'], 'content');
                                $created      = $val['created'];
                                $created_by   = $val['created_by'];
                                $modified     = $val['modified'];
                                $modified_by  = $val['modified_by'];
                                $categoryName  = $val['category_name'];
                                $thumb         =Template::showItemThumb($prefix, $val['thumb'], $val['name']);
                                $status        = Template::showItemStatus($prefix, $id, $val['status']);
                                $type         =Template::showItemSelect($prefix, $id, $val['type'], 'type');
                                //$createHistory = Template::showItemHistory($val['created'], $val['created_by']);
                                //$modifyHistory = Template::showItemHistory($val['modified'], $val['modified_by']);
                                $listButtonAction = Template::showButtonAction($prefix, $id);
                            @endphp
                            <tr class="{{$class}} pointer">
                                <td>{{$index}}</td>
                                <td width="30%">
                                   <p><strong>Name:</strong> {!!$name!!}</p>
                                   <p><strong>Content:</strong> {!! $content!!}</p>
                                </td>
                                <td width="14%">
                                 <p>{!! $thumb !!}</p>
                              </td>
                                <td> {!! $categoryName !!}</td>
                                <td width="14%"> {!! $type !!}</td>
                                <td> {!! $status !!}</td>
                                {{--<td> {!! $createHistory !!} </td>
                                <td> {!! $modifyHistory !!} </td> --}}
                                <td class="last"> {!!  $listButtonAction !!} </td>
                             </tr>
                        @endforeach
                    @else
                        <tr>
                           @include('admin.templates.list_empty', ['colspan' =>'6'])
                        </tr>
                    @endif
                </tbody>
                </table>
             </div>
          </div>
      