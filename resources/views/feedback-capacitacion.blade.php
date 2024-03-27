@extends('layouts.layout')
@section('body')
<div class="container-fluid px-1 py-5 mx-auto">
    <div class="row d-flex justify-content-center">
        <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
            <h3>Encuesta de TI</h3>
            <p class="blue-text">Solo responda algunas preguntas<br> para que podamos personalizar la experiencia para Usted.</p>
            <div class="card">
                <h5 class="text-center mb-4">Gobierno Regional de Loreto</h5>
                <form class="form-card" id="encuesta-form">
                    <div class="g-recaptcha" data-sitekey="6LeKhqUpAAAAAIRdl5eVItUZWql3iA88bT58ifcZ" data-callback="onSubmit" data-size="invisible"></div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-12 flex-column d-flex"> 
                            <label class="form-control-label"> Grado de Satisfacción en Capacitaciones de Tecnologías de la Información<span class="text-danger"> *</span></label> 
                            <select id="gradoSatisfaccion" class="form-control" aria-label="Default select example">
                                <option selected>Seleccione una opción</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 flex-column d-flex"> 
                            <label class="form-control-label">De las capacitaciones en TI - 2023, ¿Qué curso fue de su máxima atención?<span class="text-danger"> *</span></label> 
                            <select id="cursoMaximaAtencion" class="form-control" aria-label="Default select example">
                                <option selected>Seleccione una opción</option>
                                <option value="SIGEDOC">SIGEDOC</option>
                                <option value="HELPDESK">HELPDESK</option>
                                <option value="CHATBOT">CHATBOT</option>
                                <option value="OFIMATICA-WORD">OFIMATICA-WORD</option>
                                <option value="OFIMATICA-EXCEL">OFIMATICA-EXCEL</option>
                                <option value="SEGURIDAD DE LA INFORMACION">SEGURIDAD DE LA INFORMACIÓN</option>
                            </select>           
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-12 flex-column d-flex"> 
                            <label class="form-control-label">¿ Qué curso le gustaría volver a repetir o que le gustaría aprender de las TI?<span class="text-danger"> *</span></label> 
                            <select id="cursoGustariaAprender" class="form-control" aria-label="Default select example">
                                <option selected>Seleccione una opción</option>
                                <option value="Portal de Transparencia Estándar">Portal de Transparencia Estándar</option>
                                <option value="Ofimática Avanzada-IA">Ofimática Avanzada (Word-Excel) con asistencia de la Inteligencia Artificial (IA)</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 flex-column d-flex"> 
                            <label class="form-control-label">¿En qué desea que mejore o se implemente las capacitaciones de TI?<span class="text-danger"> *</span></label> 
                            <select id="opinionMejoraCapacitacion" class="form-control" aria-label="Default select example">
                                <option selected>Seleccione una opción</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Zoom">Zoom</option>
                                <option value="Equipos Tecnológicos">Equipos Tecnológicos</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-between text-left">
                        <div class="form-group col-sm-12 flex-column d-flex"> 
                            <label class="form-control-label">¿En qué Horario le gustaría capacitarse en TI?<span class="text-danger"> *</span></label> 
                            <select id="horario_capacitacion" class="form-control" aria-label="Default select example">
                                <option selected>Seleccione una opción</option>
                                <option value="SABADO - 10-12">Sábados de 10.00am-12.00pm</option>
                                <option value="VIERNES - 14-15">Viernes de 2.00pm-3.00pm</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="form-group col-sm-6">
                            <button type="button" id="submitBtn" class="btn btn-outline-secondary px-3">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection