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
                         <th class="column-title">Slider Info</th>
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
                                $description  = Highlight::show($val['description'], $params['search'], 'description');
                                $link         = Highlight::show($val['link'], $params['search'], 'link');
                                $created      = $val['created'];
                                $created_by   = $val['created_by'];
                                $modified     = $val['modified'];
                                $modified_by  = $val['modified_by'];
                                $thumb         =Template::showItemThumb($prefix, $val['thumb'], $val['name']);
                                $status        = Template::showItemStatus($prefix, $id, $val['status']);
                                $createHistory = Template::showItemHistory($val['created'], $val['created_by']);
                                $modifyHistory = Template::showItemHistory($val['modified'], $val['modified_by']);
                                $listButtonAction = Template::showButtonAction($prefix, $id);
                            @endphp
                            <tr class="{{$class}} pointer">
                                <td>{{$index}}</td>
                                <td width="40%">
                                   <p><strong>Name:</strong> {!!$name!!}</p>
                                   <p><strong>Description:</strong> {!! $description!!}</p>
                                   <p><strong>Link:</strong>{!! $link!!}</p>
                                   <p>{!! $thumb !!}</p>
                                </td>
                                <td> {!! $status !!}</td>
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
      