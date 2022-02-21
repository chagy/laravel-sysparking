<div class="modal fade" id="modalTarifa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <div class="widget-content-area ">
                    <div class="widget-one">
                        <form>			
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                    <label >Tiempo</label>
                                    <select wire:model="tiempo" class="form-control text-center">
                                        <option value="Elegir">Elegir</option>
                                        <option value="Fracción">Fracción</option>
                                        <option value="Hora">Hora</option>
                                        <option value="Día">Día</option>
                                        <option value="Semana">Semana</option>
                                        <option value="Mes">Mes</option>
                                    </select>
                                    @error('tiempo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                    <label >Tipo</label>
                                    <select wire:model="tipo" class="form-control text-center">
                                        <option value="Elegir" disabled="">Elegir</option>
                                        @foreach($tipos as $t)
                                        <option value="{{ $t->id }}" >
                                            {{ $t->descripcion}}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('tipo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                    <label >Costo</label>
                                    <input wire:model="costo" type="text" class="form-control text-center numeric"  placeholder="10.00">
                                     @error('costo') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-8 col-sm-12 mb-8">
                                    <label >Descripción</label>
                                    <input wire:model="descripcion" type="text" class="form-control"  placeholder="Tarifa Hora Coche">
                                    @error('descripcion') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                    <label >Jerarquía</label>
                                    <input wire:model="jerarquia" type="number" class="form-control text-center" >
                                    @error('jerarquia') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                            </div>
                            <div class="row ">
                                <div class="col-lg-5 mt-2  text-left">
                                    <button type="button" wire:click="doAction(1)" class="btn btn-dark mr-1">
                                    <i class="mbri-left"></i> Regresar
                                    </button>
                                    <button type="button"
                                    wire:click="StoreOrUpdate() "
                                    class="btn btn-primary ml-2">
                                    <i class="mbri-success"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>