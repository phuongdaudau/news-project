@php
    use App\Helpers\Template as Template;
    use App\Helpers\Highlight as Highlight;
@endphp
          <div class="x_content">
             <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                   <thead>
                      <tr class="headings">
                         <th class="column-title">#</th>
                         <th class="column-title">Name</th>
                         <th class="column-title">Link</th>
                         <th class="column-title">Ordering</th>
                         <th class="column-title">Source</th>
                         <th class="column-title">Trạng thái</th>
                         <th class="column-title">Tạo mới</th>
                         <th class="column-title">Chỉnh sửa</th>
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
                                $link         = Highlight::show($val['link'], $params['search'], 'link');
                                $source        = $val['source'];
                                $odering       = $val['odering'];
                                $status        = Template::showItemStatus($prefix, $id, $val['status']);
                                $createHistory = Template::showItemHistory($val['created'], $val['created_by']);
                                $modifyHistory = Template::showItemHistory($val['modified'], $val['modified_by']);
                                $listButtonAction = Template::showButtonAction($prefix, $id);
                            @endphp
                            <tr class="{{$class}} pointer">
                                <td>{{$index}}</td>
                                <td>{{$name}}</td>
                                <td>{{$link}}</td>
                                <td>{{$odering}}</td>
                                <td>{{$source}}</td>
                                <td> {!! $status !!}</td>
                                <td> {!! $createHistory !!} </td>
                                <td> {!! $modifyHistory !!} </td>
                                <td class="last"> {!!  $listButtonAction !!} </td>
                             </tr>
                        @endforeach
                    @else
                        <tr>
                           @include('admin.templates.list_empty', ['colspan' =>'9'])
                        </tr>
                    @endif
                </tbody>
                </table>
             </div>
          </div>
      