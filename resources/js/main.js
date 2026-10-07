

const table_usuario = $("#table_usuarios").DataTable({
    processing: true,
    serverSide: true,

    ajax: {
        url: "/apiUsuarios",
        type: "GET",
        data: function (d) {
            d.search = {
                value: $("#documentoUsuario").val().trim(),
            };
        },
    },

    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
            className: "text-center",
            orderable: false,
            searchable: false,
        },
        {
            data: "documento",
            render: function (data, type, row) {
                if (type !== "display") {
                    return data;
                }

                return `
                    <div class="d-flex flex-column">
                        <span class="fw-bold text-gray-800">
                            ${row.documento ?? ""}
                        </span>

                        <div class="mt-2">
                            ${row.acciones ?? ""}
                        </div>
                    </div>
                `;
            },
        },
        {
            data: "nombre_completo",
        },
        {
            data: "descripcion",
            defaultContent: "SIN TIPO",
        },
        {
            data: "estado",
            className: "text-center",
            render: function (data, type, row) {
                if (type !== "display") {
                    return data;
                }

                if (Number(row.estado) === 1) {
                    return `
                        <span class="badge badge-light-success">
                            ACTIVO
                        </span>
                    `;
                }

                return `
                    <span class="badge badge-light-danger">
                        INACTIVO
                    </span>
                `;
            },
        },
    ],

    // Índice 1 corresponde a documento
    order: [[1, "desc"]],

    responsive: true,

    lengthMenu: [
        [10, 25, 50, 100],
        [10, 25, 50, 100],
    ],

    dom:
        "<'row'<'col-sm-12'tr>>" +
        "<'row mt-5'<'col-sm-6'i><'col-sm-6 d-flex justify-content-end'p>>",

    drawCallback: function () {
        document
            .querySelectorAll('[data-bs-toggle="tooltip"]')
            .forEach(function (elemento) {
                bootstrap.Tooltip.getOrCreateInstance(elemento);
            });
    },
});

// búsqueda
let t;
$("#documentoUsuario").on("keyup", function () {
    clearTimeout(t);
    t = setTimeout(() => table_usuario.ajax.reload(), 250);
});

/*


$(".btn_editarUsuarios").on("click", function () {
    var $checkedCheckboxes = $("#table_usuarios").find(".idusuario:checked");

    if ($checkedCheckboxes.length === 0) {
        swal.fire({
            text: "Seleccionar al menos un registro",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "CANCELAR",
            customClass: {
                confirmButton: "btn btn-primary",
            },
        });
    } else if ($checkedCheckboxes.length > 1) {
        swal.fire({
            text: "Por favor, selecciona solo una casilla",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "CANCELAR",
            customClass: {
                confirmButton: "btn btn-primary",
            },
        });
    } else {
        $("#modal_usuariosEditar").modal("show");

        const modalFormUsuario = document.querySelector("#form_usuarioEditar");

        currenUsuarioId = $checkedCheckboxes.first().data("id");

        const url = "/usuarios";
        const action = url + "/" + currenUsuarioId + "/" + "edit";

        axios.get(action).then(function (response) {
            console.log(response.data);

            const urlForm = document.querySelector(".urlUsuarios");
            urlForm.setAttribute("action", `${response.data.action}`);

            const documentoUsuarioBuscar = modalFormUsuario.querySelector(
                "#documentoUsuarioBuscar",
            );
            documentoUsuarioBuscar.value = `${response.data.usuario.documento}`;

            const nombresUsuario =
                modalFormUsuario.querySelector("#nombresUsuario");
            nombresUsuario.value = `${response.data.usuario.nombres}`;

            const apellidosUsuario =
                modalFormUsuario.querySelector("#apellidosUsuario");
            apellidosUsuario.value = `${response.data.usuario.apellidos}`;

            const nickname = modalFormUsuario.querySelector("#nickname");
            nickname.value = `${response.data.usuario.nickname}`;

            const tipoUsuario_id =
                modalFormUsuario.querySelector("#tipoUsuario_id");

            var opcionesT = "<option value=''>Tipo Usuario</option>";
            for (let i in response.data.tipos) {
                if (
                    response.data.tipos[i].id ==
                    response.data.usuario.tipoUsuario_id
                ) {
                    opcionesT +=
                        '<option value="' +
                        response.data.tipos[i].id +
                        '" selected>' +
                        response.data.tipos[i].descripcion +
                        "</option>";
                } else {
                    opcionesT +=
                        '<option value="' +
                        response.data.tipos[i].id +
                        '">' +
                        response.data.tipos[i].descripcion +
                        "</option>";
                }
            }

            tipoUsuario_id.innerHTML = opcionesT;
        });
    }
});

*/

let currenUsuarioId = null;

$("#table_usuarios").on("click", ".btn_editarUsuarios", function () {
    currenUsuarioId = $(this).data("usuario-id");

    const url = "/usuarios";
    const action = url + "/" + currenUsuarioId + "/" + "edit";

    const modalFormUsuario = document.querySelector("#form_usuarioEditar");

    axios.get(action).then(function (response) {
        console.log(response.data);

        const documentoUsuarioBuscar = modalFormUsuario.querySelector(
            "#documentoUsuarioBuscar",
        );
        documentoUsuarioBuscar.value = `${response.data.usuario.dni}`;

        const nombresUsuario =
            modalFormUsuario.querySelector("#nombresUsuario");
        nombresUsuario.value = `${response.data.usuario.nombres}`;

        const apellidosUsuario =
            modalFormUsuario.querySelector("#apellidosUsuario");
        apellidosUsuario.value = `${response.data.usuario.apellidos}`;

        const nickname = modalFormUsuario.querySelector("#nickname");
        nickname.value = `${response.data.usuario.nickname}`;

        const tipoUsuario_id =
            modalFormUsuario.querySelector("#tipoUsuario_id");

        var opcionesT = "<option value=''>Tipo Usuario</option>";
        for (let i in response.data.tipos) {
            if (
                response.data.tipos[i].id ==
                response.data.usuario.tipoUsuario_id
            ) {
                opcionesT +=
                    '<option value="' +
                    response.data.tipos[i].id +
                    '" selected>' +
                    response.data.tipos[i].descripcion +
                    "</option>";
            } else {
                opcionesT +=
                    '<option value="' +
                    response.data.tipos[i].id +
                    '">' +
                    response.data.tipos[i].descripcion +
                    "</option>";
            }
        }

        tipoUsuario_id.innerHTML = opcionesT;

        const area_id = modalFormUsuario.querySelector("#area_id");

        var opcionesArea = "<option value=''>Seleccionar</option>";
        for (let a in response.data.area) {
            if (response.data.area[a].id == response.data.usuario.area_id) {
                opcionesArea +=
                    '<option value="' +
                    response.data.area[a].id +
                    '" selected>' +
                    response.data.area[a].nombre_area +
                    "</option>";
            } else {
                opcionesArea +=
                    '<option value="' +
                    response.data.area[a].id +
                    '">' +
                    response.data.area[a].nombre_area +
                    "</option>";
            }
        }

        area_id.innerHTML = opcionesArea;

        const equipo_id = modalFormUsuario.querySelector("#equipo_id");

        var opcionesEquipo = "<option value=''>Seleccionar</option>";
        for (let e in response.data.equipo) {
            if (response.data.equipo[e].id == response.data.usuario.equipo_id) {
                opcionesEquipo +=
                    '<option value="' +
                    response.data.equipo[e].id +
                    '" selected>' +
                    response.data.equipo[e].nombre_equipo +
                    "</option>";
            } else {
                opcionesEquipo +=
                    '<option value="' +
                    response.data.equipo[e].id +
                    '">' +
                    response.data.equipo[e].nombre_equipo +
                    "</option>";
            }
        }

        equipo_id.innerHTML = opcionesEquipo;

        const subequipo_id = modalFormUsuario.querySelector("#subequipo_id");

        var opcionesSubEquipo = "<option value=''>Seleccionar</option>";
        for (let sub in response.data.SubEquipo) {
            if (
                response.data.SubEquipo[sub].id ==
                response.data.usuario.sub_equipo_id
            ) {
                opcionesSubEquipo +=
                    '<option value="' +
                    response.data.SubEquipo[sub].id +
                    '" selected>' +
                    response.data.SubEquipo[sub].nombre_subequipo +
                    "</option>";
            } else {
                opcionesSubEquipo +=
                    '<option value="' +
                    response.data.SubEquipo[sub].id +
                    '">' +
                    response.data.SubEquipo[sub].nombre_subequipo +
                    "</option>";
            }
        }

        subequipo_id.innerHTML = opcionesSubEquipo;

        const arefiltro = modalFormUsuario.querySelector(".arefiltro");

        if (arefiltro) {
            arefiltro.addEventListener("change", (e) => {
                const area_id = e.target.value;

                console.log(area_id);

                axios({
                    method: "post",
                    url: "/filterEquipo",
                    data: {
                        area_id: area_id,
                    },
                }).then((res) => {
                    console.log(res.data.equipo);
                    var opciones = "<option value=''>Seleccionar</option>";
                    for (let i in res.data.equipo) {
                        opciones +=
                            '<option value="' +
                            res.data.equipo[i].id +
                            '">' +
                            res.data.equipo[i].nombre_equipo +
                            "</option>";
                    }

                    modalFormUsuario.querySelector(".filtroEquipo").innerHTML =
                        opciones;
                });
            });
        }

        const equipofiltro = modalFormUsuario.querySelector(".filtroEquipo");

        if (equipofiltro) {
            equipofiltro.addEventListener("change", (e) => {
                const equipo_id = e.target.value;

                console.log(equipo_id);

                axios({
                    method: "post",
                    url: "/filtersubEquipo",
                    data: {
                        equipo_id: equipo_id,
                    },
                }).then((res) => {
                    console.log(res.data.SubEquipo);
                    var opciones = "<option value=''>Seleccionar</option>";
                    for (let i in res.data.SubEquipo) {
                        opciones +=
                            '<option value="' +
                            res.data.SubEquipo[i].id +
                            '">' +
                            res.data.SubEquipo[i].nombre_subequipo +
                            "</option>";
                    }
                    modalFormUsuario.querySelector(".filtrosubEquipo").innerHTML =
                        opciones;
                });
            });
        }

    });
});

const form_usuarioEditar = document.querySelector("#form_usuarioEditar");

if (form_usuarioEditar) {
    form_usuarioEditar.addEventListener("submit", (e) => {
        e.preventDefault();

        const urlupdate = "/usuarios";
        const actionUpdate = urlupdate + "/" + currenUsuarioId;
        const formDataT = new FormData(form_usuarioEditar);

        axios.post(actionUpdate, formDataT).then(function (response) {
            const respuesta = response.data;

            const inputs =
                form_usuarioEditar.querySelectorAll(".validate_modal");

            inputs.forEach((input) => {
                // Eliminar errores previos

                input.classList.remove("is-invalid");
                // Buscar el contenedor padre correcto
                const wrapper =
                    input.closest(".fv-row") || input.closest(".input-group");
                const feedback = wrapper
                    ? wrapper.querySelector(".invalid-feedback")
                    : null;
                if (feedback) feedback.innerHTML = "";
                // Si hay errores de validación
                if (respuesta.errorForm && respuesta.errores[input.name]) {
                    input.classList.add("is-invalid"); // Si es un input-group, también marcamos el grupo i
                    if (input.closest(".input-group")) {
                        input
                            .closest(".input-group")
                            .classList.add("is-invalid");
                    }
                    if (feedback) {
                        feedback.innerHTML = respuesta.errores[input.name];
                    }
                }
            });

            if (!respuesta.errorForm) {
                if (respuesta) {
                    $("#modal_usuariosEditar").modal("hide");
                    table_usuario.ajax.reload();

                    //LimpiarFormularioAporte();
                }
            }
        });
    });
}

const form_usuarios = document.querySelector("#form-usuarioGuardar");

if (form_usuarios) {
    form_usuarios.addEventListener("submit", (e) => {
        e.preventDefault();

        const action = "/usuarios";
        const formDataT = new FormData(form_usuarios);

        axios.post(action, formDataT).then(function (response) {
            const respuesta = response.data;

            const inputs = form_usuarios.querySelectorAll(".validate_modal");

            inputs.forEach((input) => {
                input.classList.remove("is-invalid");
                // Buscar el contenedor padre correcto
                const wrapper =
                    input.closest(".fv-row") || input.closest(".input-group");
                const feedback = wrapper
                    ? wrapper.querySelector(".invalid-feedback")
                    : null;
                if (feedback) feedback.innerHTML = "";
                // Si hay errores de validación
                if (respuesta.errorForm && respuesta.errores[input.name]) {
                    input.classList.add("is-invalid"); // Si es un input-group, también marcamos el grupo i
                    if (input.closest(".input-group")) {
                        input
                            .closest(".input-group")
                            .classList.add("is-invalid");
                    }
                    if (feedback) {
                        feedback.innerHTML = respuesta.errores[input.name];
                    }
                }
            });

            if (!respuesta.errorForm) {
                if (respuesta) {
                    $("#modal_usuarios").modal("hide");
                    table_usuario.ajax.reload();
                }
            }
        });
    });
}

const consultaUsuario = document.querySelector("#consultaUsuario");

if (consultaUsuario) {
    consultaUsuario.addEventListener("click", (event) => {
        //console.log("hola mundo");

        const documentoBuscar = document.querySelector(
            "#documentoUsuarioBuscar",
        ).value;
        //  console.log(documentoBuscar);

        if (documentoBuscar === "") {
            $("#resp-dniRegistrarVacio").html(
                '<div class="alert alert-custom alert-notice cerrarAlerta alert-light-danger fade show mb-5" role="alert"><div class="alert-icon"><i class="fas fa-bell"></i></div><div class="alert-text">Por favor, Documento Requerido</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>',
            );
            event.preventDefault(); // Evita que se realice la acción de búsqueda
            return;
        }

        consultaUsuario.setAttribute("data-kt-indicator", "on");

        const inputapellidos = document.querySelector("#apellidosUsuario");
        const inputNombres = document.querySelector("#nombresUsuario");
        const dni = document.querySelector("#documentoUsuarioBuscar");

        axios({
            method: "POST",
            url: "/BuscarDocumentoUsuario",
            data: {
                documento: documentoBuscar,
            },
        }).then((response) => {
            const data = response.data;

            //console.log(data);

            if (data.estados == 200) {
                inputapellidos.value =
                    data.datos["aPa"] + " " + data.datos["aMa"];
                inputNombres.value = data.datos["nom"];

                dni.value = data.datos["dni"];

                consultaUsuario.removeAttribute("data-kt-indicator");
            } else if (data.estados == 400) {
                $("#resp-dniRegistrar").html(
                    '<div class="alert alert-custom alert-notice alert-light-danger cerrarAlerta fade show mb-5" role="alert"><div class="alert-icon"><i class="fas fa-bell"></i></div><div class="alert-text">Solo debe tener 8 digitos</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>',
                );

                consultaUsuario.removeAttribute("data-kt-indicator");
            } else if (data.situacion == false) {
                $("#resp-dniRegistrarVacio").html(
                    '<div class="alert alert-custom alert-notice cerrarAlerta alert-light-danger fade show mb-5" role="alert"><div class="alert-icon"><i class="fas fa-bell"></i></div><div class="alert-text">El campo Documento es requerido</div><div class="alert-close"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="ki ki-close"></i></span></button></div></div>',
                );

                consultaUsuario.removeAttribute("data-kt-indicator");
            }
        });
    });
}

const tipo_tramiteRadio = document.querySelectorAll(".tipo_tramiteRadio");

tipo_tramiteRadio.forEach((radio) => {
    radio.addEventListener("change", function (e) {
        const destino = document.querySelector(".destino_input");
        const procedimiento = document.querySelector(".procedimiento_input");

        if (e.target.value === "SIN_TUPA") {
            // Mostrar Área / Equipo / Sub equipo
            destino.classList.remove("hidden");

            // Ocultar Procedimiento
            procedimiento.classList.add("hidden");

            // Limpiar procedimiento
            $(".procedimientoSelect").val(null).trigger("change");
        } else if (e.target.value === "TUPA") {
            // Ocultar Área / Equipo / Sub equipo
            destino.classList.add("hidden");

            // Mostrar Procedimiento
            procedimiento.classList.remove("hidden");

            // Limpiar Área
            $(".arefiltro").val(null).trigger("change");

            // Limpiar Equipo
            $(".filtroEquipo").val(null).trigger("change");

            // Limpiar Sub equipo
            $(".filtrosubEquipo").val(null).trigger("change");
        }
    });
});

const arefiltro = document.querySelector(".arefiltro");

if (arefiltro) {
    arefiltro.addEventListener("change", (e) => {
        const area_id = e.target.value;

        console.log(area_id);

        axios({
            method: "post",
            url: "/filterEquipo",
            data: {
                area_id: area_id,
            },
        }).then((res) => {
            console.log(res.data.equipo);
            var opciones = "<option value=''>Seleccionar</option>";
            for (let i in res.data.equipo) {
                opciones +=
                    '<option value="' +
                    res.data.equipo[i].id +
                    '">' +
                    res.data.equipo[i].nombre_equipo +
                    "</option>";
            }
            document.querySelector(".filtroEquipo").innerHTML = opciones;
        });
    });
}

const equipofiltro = document.querySelector(".filtroEquipo");

if (equipofiltro) {
    equipofiltro.addEventListener("change", (e) => {
        const equipo_id = e.target.value;

        console.log(equipo_id);

        axios({
            method: "post",
            url: "/filtersubEquipo",
            data: {
                equipo_id: equipo_id,
            },
        }).then((res) => {
            console.log(res.data.SubEquipo);
            var opciones = "<option value=''>Seleccionar</option>";
            for (let i in res.data.SubEquipo) {
                opciones +=
                    '<option value="' +
                    res.data.SubEquipo[i].id +
                    '">' +
                    res.data.SubEquipo[i].nombre_subequipo +
                    "</option>";
            }
            document.querySelector(".filtrosubEquipo").innerHTML = opciones;
        });
    });
}

$(".solicitanteCreate").select2({
    width: "100%",
    placeholder: "Buscar solicitante",
    allowClear: true,
    // minimumInputLength: 2,
    ajax: {
        url: "/filtrosolicitante",
        dataType: "json",
        delay: 250,
        data: function (params) {
            console.log("BUSCANDO:", params.term);
            return {
                term: params.term,
            };
        },
        processResults: function (data) {
            return {
                results: data,
            };
        },
        cache: true,
    },
});

const form_tramiteExterno = document.querySelector(".form_tramiteExterno");

if (form_tramiteExterno) {
    form_tramiteExterno.addEventListener("submit", function (e) {
        e.preventDefault();

        const action = "/tramite-externo";
        const formDataT = new FormData(form_tramiteExterno);

        axios
            .post(action, formDataT)
            .then(function (response) {
                0;

                const respuesta = response.data;

                form_tramiteExterno
                    .querySelectorAll(".is-invalid")
                    .forEach(function (element) {
                        element.classList.remove("is-invalid");
                    });

                form_tramiteExterno
                    .querySelectorAll(".invalid-feedback")
                    .forEach(function (feedback) {
                        feedback.innerHTML = "";
                        feedback.style.display = "none";
                    });

                if (respuesta.errorForm) {
                    Object.entries(respuesta.errores).forEach(function ([
                        campo,
                        mensajes,
                    ]) {
                        const input = form_tramiteExterno.querySelector(
                            `[name="${campo}"]`,
                        );

                        if (!input) {
                            return;
                        }

                        const fvRow = input.closest(".fv-row");

                        if (!fvRow) {
                            return;
                        }

                        const feedback =
                            fvRow.querySelector(".invalid-feedback");

                        // INPUT / SELECT NORMAL
                        input.classList.add("is-invalid");

                        // SELECT2
                        if ($(input).hasClass("select2-hidden-accessible")) {
                            $(input)
                                .next(".select2-container")
                                .find(".select2-selection")
                                .addClass("is-invalid");
                        }

                        // MENSAJE
                        if (feedback) {
                            feedback.innerHTML = mensajes[0];

                            feedback.style.display = "block";
                        }
                    });

                    return;
                }

             
                   $("#recdartar_tramiteExterno").modal("hide");
                   // datatable.reload();

                   cargarBandeja();
                
            })
            .catch(function (error) {
                console.error(error);
            });
    });
}






document.addEventListener("DOMContentLoaded", function () {

    let bandejaActual = "por_recibir";
    let paginaActual = 1;
    let timerBusqueda = null;

    const contenedorDocumentos =
        document.getElementById("contenedorDocumentos");

    const paginacionDocumentos =
        document.getElementById("paginacionDocumentos");

    const infoPaginacion =
        document.getElementById("infoPaginacion");

    const buscarDocumento =
        document.getElementById("buscarDocumento");

    const loadingBandeja =
        document.getElementById("loadingBandeja");


    // ============================================================
    // CARGAR BANDEJA INICIAL
    // ============================================================

    cargarBandeja(bandejaActual, 1);


    // ============================================================
    // CLICK EN BANDEJAS
    // ============================================================

    document.querySelectorAll(".te-inbox-nav__item").forEach(function (link) {

        link.addEventListener("click", function () {

            document.querySelectorAll(".te-inbox-nav__item")
                .forEach(function (item) {
                    item.classList.remove("active");
                });

            this.classList.add("active");

            bandejaActual = this.dataset.tipo;
            paginaActual = 1;

            if (buscarDocumento) {
                buscarDocumento.value = "";
            }

            cambiarTitulo(bandejaActual);

            cargarBandeja(
                bandejaActual,
                paginaActual
            );

        });

    });


    // ============================================================
    // BUSCADOR
    // ============================================================

    if (buscarDocumento) {

        buscarDocumento.addEventListener("input", function () {

            clearTimeout(timerBusqueda);

            timerBusqueda = setTimeout(function () {

                paginaActual = 1;

                cargarBandeja(
                    bandejaActual,
                    paginaActual
                );

            }, 400);

        });

    }


    // ============================================================
    // CARGAR BANDEJA
    // ============================================================

    function cargarBandeja(tipo, pagina = 1) {

        const buscar =
            buscarDocumento
                ? buscarDocumento.value.trim()
                : "";

        mostrarLoading(true);

        axios.get("/apiTramiteExterno", {

            params: {
                tipo: tipo,
                page: pagina,
                buscar: buscar
            }

        })
        .then(function (response) {

            const data = response.data;

            if (!data.success) {

                mostrarError(
                    data.message ??
                    "No se pudieron cargar los documentos."
                );

                return;
            }

            pintarDocumentos(
                data.documentos ?? [],
                tipo
            );

            pintarPaginacion(
                data.pagination
            );

            paginaActual =
                data.pagination?.current_page ?? 1;

        })
        .catch(function (error) {

            console.error(
                "Error cargando bandeja:",
                error
            );

            let mensaje =
                "No se pudieron cargar los documentos.";

            if (
                error.response &&
                error.response.data &&
                error.response.data.message
            ) {
                mensaje =
                    error.response.data.message;
            }

            mostrarError(mensaje);

        })
        .finally(function () {

            mostrarLoading(false);

        });

    }


    // ============================================================
    // PINTAR DOCUMENTOS
    // ============================================================

    function pintarDocumentos(documentos, tipoBandeja) {

        if (!contenedorDocumentos) {
            return;
        }

        if (!documentos || documentos.length === 0) {

            contenedorDocumentos.innerHTML = `

                <div class="text-center py-20">

                    <div class="symbol symbol-70px mb-5">

                        <span class="symbol-label bg-light-primary">

                            <i class="
                                ki-outline
                                ki-document
                                fs-2x
                                text-primary
                            "></i>

                        </span>

                    </div>

                    <div class="fw-bold fs-5 text-gray-700">
                        No existen documentos
                    </div>

                    <div class="text-muted fs-7 mt-2">
                        No se encontraron documentos
                        en esta bandeja.
                    </div>

                </div>

            `;

            return;
        }


        let html = "";


        documentos.forEach(function (item) {

            // ----------------------------------------------------
            // OBTENER ORIGEN Y DESTINO REAL
            // ----------------------------------------------------

            const origen =
                obtenerOrigen(item);

            const destino =
                obtenerDestino(item);


            // ----------------------------------------------------
            // ESTADO
            // ----------------------------------------------------

            const estado =
                obtenerEstado(item.estado);


            // ----------------------------------------------------
            // PRIORIDAD
            // ----------------------------------------------------

            const prioridad =
                obtenerPrioridad(item.prioridad);


            // ----------------------------------------------------
            // FECHA
            // ----------------------------------------------------

            const fecha =
                formatearFecha(
                    item.fecha_movimiento
                );


            // ----------------------------------------------------
            // BOTONES
            // ----------------------------------------------------

            const botones =
                obtenerBotones(
                    item,
                    tipoBandeja
                );


            // ----------------------------------------------------
            // ORIGEN HTML
            // ----------------------------------------------------

            const htmlOrigen =
                construirOrganizacion(
                    origen,
                    "origen"
                );


            // ----------------------------------------------------
            // DESTINO HTML
            // ----------------------------------------------------

            const htmlDestino =
                construirOrganizacion(
                    destino,
                    "destino"
                );


            // ----------------------------------------------------
            // DOCUMENTO
            // ----------------------------------------------------

            html += `

                <div class="
                    documento-item
                    py-6
                    border-bottom
                ">

                    <div class="
                        d-flex
                        flex-column
                        flex-xl-row
                        align-items-xl-center
                    ">


                        <!-- ======================================
                             EXPEDIENTE
                        ======================================= -->

                        <div class="
                            d-flex
                            align-items-center
                            flex-grow-1
                            mb-5
                            mb-xl-0
                        ">

                            <div class="
                                symbol
                                symbol-50px
                                me-4
                            ">

                                <span class="
                                    symbol-label
                                    bg-light-primary
                                ">

                                    <i class="
                                        ki-outline
                                        ki-document
                                        fs-2x
                                        text-primary
                                    "></i>

                                </span>

                            </div>


                            <div class="
                                flex-grow-1
                                min-w-0
                            ">

                                <!-- EXPEDIENTE + ESTADO -->

                                <div class="
                                    d-flex
                                    flex-wrap
                                    align-items-center
                                    mb-1
                                ">

                                    <a
                                        href="javascript:void(0)"
                                        class="
                                            text-gray-900
                                            text-hover-primary
                                            fw-bold
                                            fs-6
                                            me-3
                                            btn-ver
                                        "
                                        data-id="${numeroSeguro(item.expediente_id)}"
                                    >

                                        ${escapar(
                                            item.numero_expediente ?? "-"
                                        )}

                                    </a>

                                    ${estado}

                                    ${prioridad}

                                </div>


                                <!-- DOCUMENTO -->

                                <div class="
                                    text-gray-800
                                    fw-semibold
                                    mb-2
                                ">

                                    ${escapar(
                                        item.numero_documento ?? "-"
                                    )}

                                </div>


                                <!-- ASUNTO -->

                                <div class="
                                    text-muted
                                    fs-7
                                    documento-descripcion
                                ">

                                    ${escapar(
                                        item.descripcion ?? ""
                                    )}

                                </div>


                                <!-- FECHA / FOLIOS -->

                                <div class="
                                    d-flex
                                    flex-wrap
                                    gap-4
                                    text-muted
                                    fs-8
                                    mt-3
                                ">

                                    <span>

                                        <i class="
                                            ki-outline
                                            ki-calendar
                                            me-1
                                        "></i>

                                        ${fecha.fecha}

                                    </span>

                                    <span>

                                        <i class="
                                            ki-outline
                                            ki-time
                                            me-1
                                        "></i>

                                        ${fecha.hora}

                                    </span>

                                    <span>

                                        <i class="
                                            ki-outline
                                            ki-document
                                            me-1
                                        "></i>

                                        ${escapar(
                                            item.numero_folio ?? 0
                                        )}

                                        folios

                                    </span>

                                </div>

                            </div>

                        </div>


                        <!-- ======================================
                             RUTA DEL DOCUMENTO
                        ======================================= -->

                        <div class="
                            d-flex
                            align-items-center
                            justify-content-xl-center
                            flex-grow-1
                            mx-xl-8
                            mb-5
                            mb-xl-0
                        ">


                            <!-- ORIGEN -->

                            <div style="min-width: 190px;">

                                ${htmlOrigen}

                            </div>


                            <!-- FLECHA -->

                            <div class="
                                d-flex
                                flex-column
                                align-items-center
                                mx-5
                            ">

                                <span class="
                                    text-muted
                                    fs-8
                                    mb-1
                                ">
                                    enviado a
                                </span>

                                <span class="
                                    symbol
                                    symbol-35px
                                ">

                                    <span class="
                                        symbol-label
                                        bg-light
                                    ">

                                        <i class="
                                            ki-outline
                                            ki-right
                                            fs-2
                                            text-gray-600
                                        "></i>

                                    </span>

                                </span>

                            </div>


                            <!-- DESTINO -->

                            <div style="min-width: 190px;">

                                ${htmlDestino}

                            </div>

                        </div>


                        <!-- ======================================
                             ACCIONES
                        ======================================= -->

                        <div class="
                            d-flex
                            align-items-center
                            justify-content-end
                            ms-xl-5
                        ">

                            ${botones}

                        </div>

                    </div>

                </div>

            `;

        });


        contenedorDocumentos.innerHTML =
            html;

    }


    // ============================================================
    // OBTENER ORIGEN
    // ============================================================

    function obtenerOrigen(item) {

        /*
         * IMPORTANTE:
         *
         * Se verifica primero Sub Equipo,
         * luego Equipo,
         * finalmente Área.
         *
         * De esa forma mostramos quién realmente
         * está enviando el documento.
         */


        // --------------------------------------------------------
        // SUB EQUIPO
        // --------------------------------------------------------

        if (
            item.sub_equipo_origen_id &&
            item.sub_equipo_origen
        ) {

            return {

                tipo: "Sub Equipo",

                nombre:
                    item.sub_equipo_origen,

                equipo:
                    item.equipo_origen,

                area:
                    item.area_origen,

                usuario:
                    item.usuario_origen,

                nivel: 3

            };

        }


        // --------------------------------------------------------
        // EQUIPO
        // --------------------------------------------------------

        if (
            item.equipo_origen_id &&
            item.equipo_origen
        ) {

            return {

                tipo: "Equipo",

                nombre:
                    item.equipo_origen,

                equipo:
                    item.equipo_origen,

                area:
                    item.area_origen,

                usuario:
                    item.usuario_origen,

                nivel: 2

            };

        }


        // --------------------------------------------------------
        // AREA
        // --------------------------------------------------------

        if (
            item.area_origen_id &&
            item.area_origen
        ) {

            return {

                tipo: "Área",

                nombre:
                    item.area_origen,

                equipo: null,

                area:
                    item.area_origen,

                usuario:
                    item.usuario_origen,

                nivel: 1

            };

        }


        // --------------------------------------------------------
        // SIN INFORMACIÓN
        // --------------------------------------------------------

        return {

            tipo: "Origen",

            nombre: "-",

            equipo: null,

            area: null,

            usuario:
                item.usuario_origen ?? "-",

            nivel: 0

        };

    }


    // ============================================================
    // OBTENER DESTINO
    // ============================================================

    function obtenerDestino(item) {

        /*
         * Exactamente la misma lógica:
         *
         * Sub Equipo > Equipo > Área
         */


        // --------------------------------------------------------
        // SUB EQUIPO
        // --------------------------------------------------------

        if (
            item.sub_equipo_destino_id &&
            item.sub_equipo_destino
        ) {

            return {

                tipo: "Sub Equipo",

                nombre:
                    item.sub_equipo_destino,

                equipo:
                    item.equipo_destino,

                area:
                    item.area_destino,

                usuario:
                    item.usuario_destino,

                nivel: 3

            };

        }


        // --------------------------------------------------------
        // EQUIPO
        // --------------------------------------------------------

        if (
            item.equipo_destino_id &&
            item.equipo_destino
        ) {

            return {

                tipo: "Equipo",

                nombre:
                    item.equipo_destino,

                equipo:
                    item.equipo_destino,

                area:
                    item.area_destino,

                usuario:
                    item.usuario_destino,

                nivel: 2

            };

        }


        // --------------------------------------------------------
        // AREA
        // --------------------------------------------------------

        if (
            item.area_destino_id &&
            item.area_destino
        ) {

            return {

                tipo: "Área",

                nombre:
                    item.area_destino,

                equipo: null,

                area:
                    item.area_destino,

                usuario:
                    item.usuario_destino,

                nivel: 1

            };

        }


        // --------------------------------------------------------
        // SIN DESTINO
        // --------------------------------------------------------

        return {

            tipo: "Destino",

            nombre: "-",

            equipo: null,

            area: null,

            usuario:
                item.usuario_destino ?? "-",

            nivel: 0

        };

    }


    // ============================================================
    // CONSTRUIR ORGANIZACIÓN
    // ============================================================

    function construirOrganizacion(datos, tipo) {

        const esOrigen =
            tipo === "origen";


        const claseBadge =
            esOrigen
                ? "badge-light-primary"
                : "badge-light-success";


        const claseIcono =
            esOrigen
                ? "text-primary"
                : "text-success";


        const claseFondo =
            esOrigen
                ? "bg-light-primary"
                : "bg-light-success";


        let detalleSuperior = "";


        /*
         * SUB EQUIPO
         *
         * Mostramos:
         *
         * SUB EQUIPO
         * Escalafón
         * Recursos Humanos
         * Administración
         */

        if (datos.nivel === 3) {

            detalleSuperior = `

                ${
                    datos.equipo
                        ? `
                            <span class="
                                text-muted
                                fs-8
                            ">
                                ${escapar(datos.equipo)}
                            </span>
                        `
                        : ""
                }

                ${
                    datos.area
                        ? `
                            <span class="
                                text-muted
                                fs-8
                            ">
                                ${escapar(datos.area)}
                            </span>
                        `
                        : ""
                }

            `;

        }


        /*
         * EQUIPO
         *
         * EQUIPO
         * Recursos Humanos
         * Administración
         */

        if (datos.nivel === 2) {

            detalleSuperior = `

                ${
                    datos.area
                        ? `
                            <span class="
                                text-muted
                                fs-8
                            ">
                                ${escapar(datos.area)}
                            </span>
                        `
                        : ""
                }

            `;

        }


        return `

            <div class="
                d-flex
                align-items-start
            ">

                <!-- ICONO -->

                <div class="
                    symbol
                    symbol-40px
                    me-3
                    flex-shrink-0
                ">

                    <span class="
                        symbol-label
                        ${claseFondo}
                    ">

                        <i class="
                            ki-outline
                            ${obtenerIconoOrganizacion(datos.nivel)}
                            fs-2
                            ${claseIcono}
                        "></i>

                    </span>

                </div>


                <!-- DATOS -->

                <div class="
                    d-flex
                    flex-column
                    min-w-0
                ">

                    <!-- TIPO -->

                    <span class="
                        badge
                        ${claseBadge}
                        align-self-start
                        mb-1
                    ">

                        ${escapar(datos.tipo)}

                    </span>


                    <!-- NOMBRE PRINCIPAL -->

                    <span class="
                        text-gray-900
                        fw-bold
                        fs-7
                    ">

                        ${escapar(datos.nombre)}

                    </span>


                    <!-- JERARQUÍA -->

                    ${detalleSuperior}


                    <!-- USUARIO -->

                    <span class="
                        text-gray-600
                        fs-8
                        mt-2
                    ">

                        <i class="
                            ki-outline
                            ki-user
                            fs-8
                            me-1
                        "></i>

                        ${escapar(
                            datos.usuario ?? "-"
                        )}

                    </span>

                </div>

            </div>

        `;

    }


    // ============================================================
    // ICONO SEGÚN NIVEL
    // ============================================================

    function obtenerIconoOrganizacion(nivel) {

        switch (nivel) {

            case 3:
                return "ki-people";

            case 2:
                return "ki-abstract-26";

            case 1:
                return "ki-office-bag";

            default:
                return "ki-information";

        }

    }


    // ============================================================
    // ESTADO
    // ============================================================

    function obtenerEstado(estado) {

        switch (estado) {

            case "POR_RECIBIR":

                return `

                    <span class="
                        badge
                        badge-light-warning
                    ">

                        <span class="
                            bullet
                            bullet-dot
                            bg-warning
                            me-2
                        "></span>

                        Por recibir

                    </span>

                `;


            case "RECIBIDO":

                return `

                    <span class="
                        badge
                        badge-light-primary
                    ">

                        <span class="
                            bullet
                            bullet-dot
                            bg-primary
                            me-2
                        "></span>

                        Recibido

                    </span>

                `;


            case "EN_ATENCION":

                return `

                    <span class="
                        badge
                        badge-light-info
                    ">

                        <span class="
                            bullet
                            bullet-dot
                            bg-info
                            me-2
                        "></span>

                        En atención

                    </span>

                `;


            case "ATENDIDO":

                return `

                    <span class="
                        badge
                        badge-light-success
                    ">

                        <i class="
                            ki-outline
                            ki-check-circle
                            fs-7
                            me-1
                        "></i>

                        Atendido

                    </span>

                `;


            case "ARCHIVADO":

                return `

                    <span class="
                        badge
                        badge-light-dark
                    ">
                        Archivado
                    </span>

                `;


            default:

                return `

                    <span class="
                        badge
                        badge-light
                    ">

                        ${escapar(
                            estado ?? "-"
                        )}

                    </span>

                `;

        }

    }


    // ============================================================
    // PRIORIDAD
    // ============================================================

    function obtenerPrioridad(prioridad) {

        if (!prioridad) {
            return "";
        }


        switch (
            String(prioridad).toUpperCase()
        ) {

            case "URGENTE":

                return `

                    <span class="
                        badge
                        badge-light-danger
                        ms-2
                    ">

                        <i class="
                            ki-outline
                            ki-notification-status
                            fs-7
                            me-1
                        "></i>

                        Urgente

                    </span>

                `;


            case "ALTA":

                return `

                    <span class="
                        badge
                        badge-light-warning
                        ms-2
                    ">
                        Alta
                    </span>

                `;


            default:

                return "";

        }

    }


    // ============================================================
    // BOTONES
    // ============================================================

    function obtenerBotones(item, tipo) {

        let html = `

            <button
                type="button"
                class="
                    btn
                    btn-icon
                    btn-light-primary
                    btn-sm
                    me-2
                    btn-ver
                "
                data-id="${numeroSeguro(item.expediente_id)}"
                title="Ver expediente"
            >

                <i class="
                    ki-outline
                    ki-eye
                    fs-2
                "></i>

            </button>

        `;


        // --------------------------------------------------------
        // POR RECIBIR
        // --------------------------------------------------------

        if (tipo === "por_recibir") {

            html += `

                <button
                    type="button"
                    class="
                        btn
                        btn-sm
                        btn-success
                        btn-recibir
                    "
                    data-id="${numeroSeguro(item.movimiento_id)}"
                >

                    <i class="
                        ki-outline
                        ki-check
                        fs-3
                    "></i>

                    Recibir

                </button>

            `;

        }


        // --------------------------------------------------------
        // RECIBIDOS
        // --------------------------------------------------------

        if (tipo === "recibidos") {

            html += `

                <button
                    type="button"
                    class="
                        btn
                        btn-icon
                        btn-light-info
                        btn-sm
                        me-2
                        btn-atender
                    "
                    data-id="${numeroSeguro(item.movimiento_id)}"
                    title="Poner en atención"
                >

                    <i class="
                        ki-outline
                        ki-document
                        fs-2
                    "></i>

                </button>


                <button
                    type="button"
                    class="
                        btn
                        btn-icon
                        btn-light-warning
                        btn-sm
                        btn-derivar
                    "
                    data-id="${numeroSeguro(item.expediente_id)}"
                    data-movimiento="${numeroSeguro(item.movimiento_id)}"
                    title="Derivar"
                >

                    <i class="
                        ki-outline
                        ki-send
                        fs-2
                    "></i>

                </button>

            `;

        }


        // --------------------------------------------------------
        // EN ATENCIÓN
        // --------------------------------------------------------

        if (tipo === "en_atencion") {

            html += `

                <button
                    type="button"
                    class="
                        btn
                        btn-icon
                        btn-light-warning
                        btn-sm
                        me-2
                        btn-derivar
                    "
                    data-id="${numeroSeguro(item.expediente_id)}"
                    data-movimiento="${numeroSeguro(item.movimiento_id)}"
                    title="Derivar"
                >

                    <i class="
                        ki-outline
                        ki-send
                        fs-2
                    "></i>

                </button>


                <button
                    type="button"
                    class="
                        btn
                        btn-icon
                        btn-light-success
                        btn-sm
                        btn-finalizar
                    "
                    data-id="${numeroSeguro(item.movimiento_id)}"
                    title="Marcar como atendido"
                >

                    <i class="
                        ki-outline
                        ki-check-circle
                        fs-2
                    "></i>

                </button>

            `;

        }


        // --------------------------------------------------------
        // DERIVADOS
        // --------------------------------------------------------

        if (tipo === "derivados") {

            html += `

                <button
                    type="button"
                    class="
                        btn
                        btn-sm
                        btn-light
                        btn-seguimiento
                    "
                    data-id="${numeroSeguro(item.expediente_id)}"
                >

                    <i class="
                        ki-outline
                        ki-route
                        fs-3
                    "></i>

                    Seguimiento

                </button>

            `;

        }


        return html;

    }


    // ============================================================
    // PAGINACIÓN
    // ============================================================

    function pintarPaginacion(pagination) {

        if (
            !pagination ||
            !paginacionDocumentos ||
            !infoPaginacion
        ) {
            return;
        }


        // --------------------------------------------------------
        // INFORMACIÓN
        // --------------------------------------------------------

        infoPaginacion.innerHTML = `

            Mostrando

            <strong>
                ${pagination.from ?? 0}
            </strong>

            a

            <strong>
                ${pagination.to ?? 0}
            </strong>

            de

            <strong>
                ${pagination.total ?? 0}
            </strong>

            documentos

        `;


        // --------------------------------------------------------
        // UNA SOLA PÁGINA
        // --------------------------------------------------------

        if (
            !pagination.last_page ||
            pagination.last_page <= 1
        ) {

            paginacionDocumentos.innerHTML =
                "";

            return;
        }


        let html = "";

        const actual =
            Number(
                pagination.current_page
            );

        const ultima =
            Number(
                pagination.last_page
            );


        // --------------------------------------------------------
        // ANTERIOR
        // --------------------------------------------------------

        html += `

            <li class="
                page-item
                previous
                ${actual === 1 ? "disabled" : ""}
            ">

                <a
                    href="javascript:void(0)"
                    class="
                        page-link
                        pagina-link
                    "
                    data-page="${actual - 1}"
                >

                    <i class="previous"></i>

                </a>

            </li>

        `;


        // --------------------------------------------------------
        // RANGO
        // --------------------------------------------------------

        let inicio =
            Math.max(
                1,
                actual - 2
            );

        let fin =
            Math.min(
                ultima,
                actual + 2
            );


        // --------------------------------------------------------
        // PRIMERA PÁGINA
        // --------------------------------------------------------

        if (inicio > 1) {

            html += crearPagina(
                1,
                actual
            );

            if (inicio > 2) {

                html += `

                    <li class="
                        page-item
                        disabled
                    ">

                        <span class="page-link">
                            ...
                        </span>

                    </li>

                `;

            }

        }


        // --------------------------------------------------------
        // PÁGINAS CENTRALES
        // --------------------------------------------------------

        for (
            let pagina = inicio;
            pagina <= fin;
            pagina++
        ) {

            html += crearPagina(
                pagina,
                actual
            );

        }


        // --------------------------------------------------------
        // ÚLTIMA PÁGINA
        // --------------------------------------------------------

        if (fin < ultima) {

            if (fin < ultima - 1) {

                html += `

                    <li class="
                        page-item
                        disabled
                    ">

                        <span class="page-link">
                            ...
                        </span>

                    </li>

                `;

            }

            html += crearPagina(
                ultima,
                actual
            );

        }


        // --------------------------------------------------------
        // SIGUIENTE
        // --------------------------------------------------------

        html += `

            <li class="
                page-item
                next
                ${actual === ultima ? "disabled" : ""}
            ">

                <a
                    href="javascript:void(0)"
                    class="
                        page-link
                        pagina-link
                    "
                    data-page="${actual + 1}"
                >

                    <i class="next"></i>

                </a>

            </li>

        `;


        paginacionDocumentos.innerHTML =
            html;

    }


    // ============================================================
    // CREAR PÁGINA
    // ============================================================

    function crearPagina(pagina, actual) {

        return `

            <li class="
                page-item
                ${pagina === actual ? "active" : ""}
            ">

                <a
                    href="javascript:void(0)"
                    class="
                        page-link
                        pagina-link
                    "
                    data-page="${pagina}"
                >

                    ${pagina}

                </a>

            </li>

        `;

    }


    // ============================================================
    // CLICK PAGINACIÓN
    // ============================================================

    document.addEventListener("click", function (e) {

        const boton =
            e.target.closest(
                ".pagina-link"
            );

        if (!boton) {
            return;
        }


        const item =
            boton.closest(
                ".page-item"
            );


        if (
            item &&
            item.classList.contains(
                "disabled"
            )
        ) {
            return;
        }


        const pagina =
            parseInt(
                boton.dataset.page
            );


        if (
            !pagina ||
            pagina < 1
        ) {
            return;
        }


        paginaActual =
            pagina;


        cargarBandeja(
            bandejaActual,
            paginaActual
        );


        /*
         * Subir suavemente
         */

        const titulo =
            document.getElementById(
                "tituloBandeja"
            );

        if (titulo) {

            titulo.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });

        }

    });


    // ============================================================
    // TITULO DE BANDEJA
    // ============================================================

    function cambiarTitulo(tipo) {

        const configuracion = {

            por_recibir: {

                titulo:
                    "Por recibir",

                descripcion:
                    "Documentos pendientes de recepción"

            },

            recibidos: {

                titulo:
                    "Recibidos",

                descripcion:
                    "Documentos recibidos por su oficina"

            },

            en_atencion: {

                titulo:
                    "En atención",

                descripcion:
                    "Documentos actualmente en trámite"

            },

            derivados: {

                titulo:
                    "Derivados",

                descripcion:
                    "Documentos enviados a otras oficinas"

            },

            atendidos: {

                titulo:
                    "Atendidos",

                descripcion:
                    "Documentos que finalizaron su atención"

            }

        };


        const datos =
            configuracion[tipo];

        if (!datos) {
            return;
        }


        const titulo =
            document.getElementById(
                "tituloBandeja"
            );

        const descripcion =
            document.getElementById(
                "descripcionBandeja"
            );


        if (titulo) {
            titulo.textContent =
                datos.titulo;
        }

        if (descripcion) {
            descripcion.textContent =
                datos.descripcion;
        }

    }


    // ============================================================
    // FECHA
    // ============================================================

    function formatearFecha(fecha) {

        if (!fecha) {

            return {
                fecha: "-",
                hora: "-"
            };

        }


        /*
         * Laravel normalmente manda:
         *
         * 2026-09-25 10:30:00
         *
         * Reemplazamos espacio para mejorar
         * compatibilidad del navegador.
         */

        const fechaCompatible =
            String(fecha)
                .replace(" ", "T");


        const date =
            new Date(
                fechaCompatible
            );


        if (isNaN(date.getTime())) {

            return {
                fecha: escapar(fecha),
                hora: "-"
            };

        }


        return {

            fecha:
                date.toLocaleDateString(
                    "es-PE",
                    {
                        day: "2-digit",
                        month: "2-digit",
                        year: "numeric"
                    }
                ),

            hora:
                date.toLocaleTimeString(
                    "es-PE",
                    {
                        hour: "2-digit",
                        minute: "2-digit",
                        hour12: true
                    }
                )

        };

    }


    // ============================================================
    // LOADING
    // ============================================================

    function mostrarLoading(mostrar) {

        if (!loadingBandeja) {
            return;
        }


        if (mostrar) {

            loadingBandeja.classList
                .remove("d-none");

            if (contenedorDocumentos) {
                contenedorDocumentos.innerHTML = "";
            }

        } else {

            loadingBandeja.classList
                .add("d-none");

        }

    }


    // ============================================================
    // ERROR
    // ============================================================

    function mostrarError(mensaje) {

        if (!contenedorDocumentos) {
            return;
        }


        contenedorDocumentos.innerHTML = `

            <div class="text-center py-20">

                <div class="
                    symbol
                    symbol-70px
                    mb-5
                ">

                    <span class="
                        symbol-label
                        bg-light-danger
                    ">

                        <i class="
                            ki-outline
                            ki-information-5
                            fs-2x
                            text-danger
                        "></i>

                    </span>

                </div>

                <div class="
                    fw-bold
                    fs-5
                    text-gray-700
                ">

                    No se pudieron cargar
                    los documentos

                </div>

                <div class="
                    text-muted
                    fs-7
                    mt-2
                ">

                    ${escapar(mensaje)}

                </div>

            </div>

        `;


        if (paginacionDocumentos) {
            paginacionDocumentos.innerHTML = "";
        }

        if (infoPaginacion) {
            infoPaginacion.innerHTML = "";
        }

    }


    // ============================================================
    // ESCAPAR HTML
    // ============================================================

    function escapar(valor) {

        if (
            valor === null ||
            valor === undefined
        ) {
            return "";
        }


        const div =
            document.createElement(
                "div"
            );

        div.textContent =
            String(valor);

        return div.innerHTML;

    }


    // ============================================================
    // NÚMEROS SEGUROS PARA DATA-ID
    // ============================================================

    function numeroSeguro(valor) {

        const numero =
            parseInt(valor);

        return Number.isInteger(numero)
            ? numero
            : 0;

    }

});


$(".destinoCreate").select2({
    width: "100%",
    placeholder: "Buscar",
    allowClear: true,
    // minimumInputLength: 2,
    ajax: {
        url: "/filtrodominio",
        dataType: "json",
        delay: 250,
        data: function (params) {
            console.log("BUSCANDO:", params.term);
            return {
                term: params.term,
            };
        },
        processResults: function (data) {
            return {
                results: data,
            };
        },
        cache: true,
    },
});

// ============================================================
// TIPO USUARIO
// ============================================================

if (document.getElementById("table_tipoUsuario")) {
    const table_tipoUsuario = $("#table_tipoUsuario").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/apiTipoUsuarios",
            type: "GET",
            data: function (d) {
                d.search = {
                    value: $("#documentoTipousuario").val().trim(),
                };
            },
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                className: "text-center",
                orderable: false,
                searchable: false,
            },
            {
                data: "descripcion",
                render: function (data, type, row) {
                    return `<span class="fw-bold text-gray-800">${row.descripcion ?? ""}</span>`;
                },
            },
            {
                data: "acciones",
                orderable: false,
                searchable: false,
                className: "text-center",
            },
        ],
        order: [[1, "asc"]],
        responsive: true,
        lengthMenu: [
            [10, 25, 50, 100],
            [10, 25, 50, 100],
        ],
        dom:
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-5'<'col-sm-6'i><'col-sm-6 d-flex justify-content-end'p>>",
        drawCallback: function () {
            document
                .querySelectorAll('[data-bs-toggle="tooltip"]')
                .forEach(function (elemento) {
                    bootstrap.Tooltip.getOrCreateInstance(elemento);
                });
        },
    });

    let tTipoUsuario;
    $("#documentoTipousuario").on("keyup", function () {
        clearTimeout(tTipoUsuario);
        tTipoUsuario = setTimeout(() => table_tipoUsuario.ajax.reload(), 250);
    });
}

const form_tipoUsuarioGuardar = document.querySelector("#form_tipoUsuarioGuardar");
if (form_tipoUsuarioGuardar) {
    form_tipoUsuarioGuardar.addEventListener("submit", (e) => {
        e.preventDefault();
        const action = "/tipo-usuario";
        const formDataT = new FormData(form_tipoUsuarioGuardar);

        axios.post(action, formDataT).then(function (response) {
            const respuesta = response.data;
            const inputs = form_tipoUsuarioGuardar.querySelectorAll(".validate_modal");

            inputs.forEach((input) => {
                input.classList.remove("is-invalid");
                const wrapper = input.closest(".fv-row") || input.closest(".input-group");
                const feedback = wrapper ? wrapper.querySelector(".invalid-feedback") : null;
                if (feedback) feedback.innerHTML = "";
                
                if (respuesta.errorForm && respuesta.errores[input.name]) {
                    input.classList.add("is-invalid");
                    if (input.closest(".input-group")) {
                        input.closest(".input-group").classList.add("is-invalid");
                    }
                    if (feedback) {
                        feedback.innerHTML = respuesta.errores[input.name][0];
                    }
                }
            });

            if (!respuesta.errorForm && respuesta.success) {
                $("#modal_tipoUsuario").modal("hide");
                form_tipoUsuarioGuardar.reset();
                if ($.fn.DataTable.isDataTable('#table_tipoUsuario')) {
                    $('#table_tipoUsuario').DataTable().ajax.reload();
                } else {
                    window.location.href = respuesta.ruta;
                }
            }
        });
    });
}

const form_tipoUsuarioEditar = document.querySelector("#form_tipoUsuarioEditar");
if (form_tipoUsuarioEditar) {
    form_tipoUsuarioEditar.addEventListener("submit", (e) => {
        e.preventDefault();
        const action = form_tipoUsuarioEditar.getAttribute("action");
        const formDataT = new FormData(form_tipoUsuarioEditar);

        axios.post(action, formDataT).then(function (response) {
            const respuesta = response.data;
            const inputs = form_tipoUsuarioEditar.querySelectorAll(".validate_modal");

            inputs.forEach((input) => {
                input.classList.remove("is-invalid");
                const wrapper = input.closest(".fv-row") || input.closest(".input-group");
                const feedback = wrapper ? wrapper.querySelector(".invalid-feedback") : null;
                if (feedback) feedback.innerHTML = "";
                
                if (respuesta.errorForm && respuesta.errores[input.name]) {
                    input.classList.add("is-invalid");
                    if (input.closest(".input-group")) {
                        input.closest(".input-group").classList.add("is-invalid");
                    }
                    if (feedback) {
                        feedback.innerHTML = respuesta.errores[input.name][0];
                    }
                }
            });

            if (!respuesta.errorForm && respuesta.success) {
                window.location.href = respuesta.ruta;
            }
        });
    });
}