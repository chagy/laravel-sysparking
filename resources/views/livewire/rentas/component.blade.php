<div>
    @if ($section == 1)
    <div class="main-content">
        <div class="layout-xp-spacing">
            <div class="row">
                <div class="col-lg-12 layout-xp-spacing layout-top-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 mt-3">
                                    <h3 class="text-center">Rentas</h3>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <div class="row mt-1">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="la la-barcode"></i>
                                            </span>
                                        </div>
                                        <input 
                                            type="text" 
                                            id="code" 
                                            wire:keydown.enter="$emit('doCheckOut','',2)" 
                                            wire:model="barcode" 
                                            class="form-control" 
                                            maxlength="9" 
                                            placeholder="Escanea el codigo de barras" 
                                            autofocus />
                                        <div class="input-group-append">
                                            <span 
                                                wire:click="$set('barcode','')" 
                                                class="input-group-text" 
                                                style="cursor: pointer;">
                                                <i class="la la-remove la-lg"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <button wire:click.prevent="TicketVisita()" class="btn btn-primary btn-lg btn-block">
                                        TICKET DE VISIT
                                    </button>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <button wire:click.prevent="$set('section',3)" class="btn btn-primary btn-lg btn-block">
                                        TICKET DE RENTA
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        @foreach ($cajones as $c)
                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xm-6">
                                            @if ($c->estatus == 'DISPONIBLE')
                                                <span 
                                                    id="{{ $c->tarifa_id }}" style="cursor: pointer;" 
                                                    data-status="{{ $c->status }}" 
                                                    data-id="{{ $c->id }}" 
                                                    onclick="openModal('{{ $c->tarifa_id }}','{{ $c->id }}')" 
                                                    class="badge-chip badge-success mt-3 mb-3 ml-2 btncajon bs-popover">
                                                
                                            @else 
                                                <span 
                                                    id="{{ $c->tarifa_id }}" style="cursor: pointer;" 
                                                    data-status="{{ $c->status }}" 
                                                    data-id="{{ $c->id }}" 
                                                    data-barcode="{{ $c->barcode }}"
                                                    onclick="eventClick('doCheckOut','{{ $c->barcode }}','2')" 
                                                    class="badge-chip badge-success mt-3 mb-3 ml-2 btncajon bs-popover">
                                            @endif
                                                    <img 
                                                        src="images/{{$c->imagen}}" 
                                                        alt="" 
                                                        class="img" 
                                                        height="96" 
                                                        width="96" />
                                                    <span>{{ $c->descripcion }}</span>
                                                </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" id="tarifa">
                                <input type="hidden" id="cajon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalRenta" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Descripcion del Vehiculo</h5>
                    </div>
                    <div class="modal-body">
                        <input
                            type="text" 
                            id="comment" 
                            maxlength="30" 
                            class="form-control" 
                            autofocus />
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark" data-dismiss="modal">
                            <i class="flaticon-cancel-12"></i> 
                            Cancelar
                        </button>
                        <button class="btn btn-primary saveRenta">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif($section == 2)
    @include('livewire.rentas.salidas')
    @elseif($section == 3)
    @include('livewire.rentas.tickettranta')
    @endif
</div>
<script>
    function openModal(tarifa,cajon)
    {
        $('#tarifa').val(tarifa)
        $("#cajon").val(cajon)

        $("#modalRenta").modal('show')
    }

    function eventCheckOut(eventName,barcode,actionValue)
    {
        window.livewire.emit(eventName,barcode,actionValue)
        $("#modalRenta").modal('hide');
        $("#comment").val('')
    }

    document.addEventListener('DOMContentLoaded',function(){
        $('body').on('click','.saveRenta',function(){
            var ta = $('#tarifa').val()
            var ca = $('#cajon').val()
            $("#modalRenta").modal('hide');
            window.livewire.emit('doCheckIn',ta,ca,'DISPONIBLE',$.trim($('#comment').val()))
            $('#comment').val('')
        })

        window.livewire.on('print',ticket => {
            var ruta = "{{ url('print/order') }}" + '/' + ticket;
            var w = window.open(ruta,"_blank","width=100, height=100")
            w.close()
        })

        window.livewire.on('print-pension',ticket => {
            var ruta = "{{ url('print/pension') }}" + '/' + ticket;
            var w = window.open(ruta,"_blank","width=100, height=100")
            w.close()
        })
    })
</script>