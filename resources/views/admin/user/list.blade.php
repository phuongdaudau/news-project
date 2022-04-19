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
                         <th class="column-title">Username</th>
                         <th class="column-title">Fullname</th>
                         <th class="column-title">Email</th>
                         <th class="column-title">Level</th>
                         <th class="column-title">Avatar</th>
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
                                $index          = $key +1;
                                $id             = $val['id'];
                                $class          = ($index%2 ==0) ?"even" :"odd";
                                $username       = Highlight::show($val['username'], $params['search'], 'username');
                                $fullname       = Highlight::show($val['fullname'], $params['search'], 'fullname');
                                $email          = Highlight::show($val['email'], $params['search'], 'email');
                                $avatar         = Template::showItemThumb($prefix, $val['avatar'], $val['fullname']);
                                $level          = Template::showItemSelect($prefix, $id, $val['level'], 'level');
                                $status         = Template::showItemStatus($prefix, $id, $val['status']);
                                $createHistory  = Template::showItemHistory($val['created'], $val['created_by']);
                                $modifyHistory  = Template::showItemHistory($val['modified'], $val['modified_by']);
                                $listButtonAction = Template::showButtonAction($prefix, $id);
                            @endphp
                            <tr class="{{$class}} pointer">
                                <td>{{$index}}</td>
                                <td width="7%">{!! $username !!}</td>
                                <td width="10%">{!! $fullname !!}</td>
                                <td width="10%">{!! $email !!}</td>
                                <td width="5%">{!! $avatar !!}</td>
                                <td width="10%">{!! $level !!}</td>
                                <td width="10%"> {!! $status !!}</td>
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
      