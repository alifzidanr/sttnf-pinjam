@extends('layouts.admin')
@section('content')
@can('event_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.events.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.event.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.event.title_singular') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        
                        
                        <th>
                            {{ trans('cruds.event.fields.id') }}
                        </th>
                        @can('event_accept')
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.action') }}
                        </th>
                        @endcan  
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.room') }}
                        </th>
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.user') }}
                        </th>

                        @can('event_accept')
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.usercontact') }}
                        </th>
                        @endcan

                        <th style="text-align:center">
                            {{ trans('cruds.room.fields.capacity') }}
                        </th>
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.end_time') }}
                        </th>
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.description') }}
                        </th>
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.resp') }}
                        </th>
                        @can('event_showcontact')
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.resp_no') }}
                        </th>
                        @endcan
                        {{-- <th style="text-align:center">
                            {{ trans('cruds.room.fields.email') }}
                        </th> --}}
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.status') }}
                        </th>
                        <th style="text-align:center">
                            {{ trans('cruds.event.fields.option') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $key => $event)
                        <tr data-entry-id="{{ $event->id }}">
                            <td>

                            </td>
                            
                            <td>
                                {{ $event->id ?? '' }}
                            </td>

                            @can('event_accept')
                            <td style="text-align:center">
                                <form action="{{ route('accept', $event->id) }}" onsubmit="return confirm('{{ trans('global.accept') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-success" value="{{ trans('global.terima') }}">
                                    </form>

                                @can('event_deny')
                                <form action="{{ route('deny', $event->id) }}" onsubmit="return confirm('{{ trans('global.reject') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-danger" value="{{ trans('global.tolak') }}">
                                    </form>
                                @endcan
                            </td>
                            @endcan
                        
                            <td style="text-align:center">
                                {{ $event->room->name ?? '' }}
                            </td>
                            <td style="text-align:center">
                                {{ $event->user->name ?? '' }}
                            </td>

                            @can('event_accept')
                            <td>
                                {{ $event->user->usercontact ?? '' }}
                            </td>
                            @endcan

                            <td style="text-align:center">
                                {{ $event->room->capacity ?? '' }}
                            </td>
                            <td style="text-align:center">
                                {{ $event->title ?? '' }}
                            </td>
                            <td>
                                {{ $event->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $event->end_time ?? '' }}
                            </td>
                            <td>
                                {{ $event->description ?? '' }}
                            </td>

                            <td>
                                {{ $event->room->resp ?? '' }}
                            </td>
                              
                            @can('event_showcontact')
                            <td>
                                {{ $event->room->resp_no ?? '' }}
                            </td>
                            @endcan

                            
                            <td style="font-size: 18px;" class="text-center">
                                <div class="d-flex justify-content-center">
                                    <span class="badge badge-lg
                                        @if($event->status == 'Diterima') 
                                            badge-success
                                        @elseif($event->status == 'Ditolak')
                                            badge-danger
                                        @else 
                                            badge-secondary 
                                        @endif">
                                        
                                        {{ $event->status ?? '' }}
                                    </span> 
                                </div>
                            </td>
                            
                            
                            
                            
                            
                            <td style="text-align:center">
                               
                                
                                @can('event_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.events.show', $event->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('event_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.events.edit', $event->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('event_delete')
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('event_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.events.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Event:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection