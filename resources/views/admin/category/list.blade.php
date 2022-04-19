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
                         <th class="column-title">Name</th>
                         <th class="column-title">Trạng thái</th>
                         <th class="column-title">Hiển thị Home</th>
                         <th class="column-title">Kiểu hiển thị</th>
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
                                $status       = Template::showItemStatus($prefix, $id, $val['status']);
                                $isHome       = Template::showItemIsHome($prefix, $id, $val['is_home']);
                                $display       = Template::showItemSelect($prefix, $id, $val['display'], 'display');
                                $createHistory = Template::showItemHistory($val['created'], $val['created_by']);
                                $modifyHistory = Template::showItemHistory($val['modified'], $val['modified_by']);
                                $listButtonAction = Template::showButtonAction($prefix, $id);
                            @endphp
                            <tr class="{{$class}} pointer">
                                <td>{{$index}}</td>
                                <td width="20%"><p><strong>{!!$name!!}</strong> </p></td>
                                <td> {!! $status !!}</td>
                                <td> {!! $isHome !!}</td>
                                <td> {!! $display !!}</td>
                                <td> {!! $createHistory !!} </td>
                                <td> {!! $modifyHistory !!} </td>
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
      