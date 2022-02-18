<div class="widget-content-area">
    <div class="widget-one">
        <form>
            <h3>Create/Editar Movimientos</h3>
            @include('common.messages')

            <div class="row">
                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label for="">Tipo</label>
                    <select name="" id="" wire:model="tipo">
                        <option value="Elegir">Elegir</option>
                        <option value="Ingreso">Ingreso</option>
                        <option value="Gasto">Gasto</option>
                        <option value="Pago de Renta">Pago de Renta</option>
                    </select>
                </div>

                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label for="">Monto</label>
                    <input 
                        type="number" 
                        wire:model.lazy="monto" 
                        class="form-control text-center" 
                        placeholder="ej: 100.00" />
                </div>

                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label for="">Comprobante</label>
                    <input 
                        type="file" 
                        class="form-control text-center" 
                        wire:change="$emit('fileChoose',this)" 
                        accept="image/x-png,image/gif,image/jpeg"/>
                </div>

                <div class="form-group col-lg-12 col-sm-12 mb-8">
                    <label for="">Ingresa la descripcion</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        wire:model.lazy="concepto" 
                        placeholder="...." />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 mt-2 text-left">
                    <button type="button" class="btn btn-dark mr-1" wire:click="doAction(1)">
                        <i class="mbri-left"></i> 
                        Regresar
                    </button>
                    <button type="button" class="btn btn-primary ml-2" wire:click.prevent="StoreOrUpdate">
                        <i class="mbri-success"></i> 
                        Guardar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>