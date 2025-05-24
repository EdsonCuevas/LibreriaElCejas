const app = {
    routes : {
        getBooks : "/Books/getBooks",
        updateBook: "/Books/updateBook",
        deleteBook: "/Books/deleteBook",
        getAuthors : "/Authors/getAuthors",
        getCategories : "/Categories/getCategories",
        addCategory : "/Categories/addCategory",
        deleteCategory : "/Categories/deleteCategory",
        updateCategory : "/Categories/updateCategory",

        addAuthor : "/Authors/addAuthor",
        deleteAuthor: "/Authors/deleteAuthor",
        editAuthor: "/Authors/editAuthor"
    },

    loadBooks: async function () {
    try {
        const books = await $.getJSON(this.routes.getBooks);
        console.log(books)

        let html = '';
        if (books.length === 0) {
            html = `<tr><td colspan="5">No hay libros disponibles.</td></tr>`;
        } else {
            books.forEach(book => {
                html += `
                    <tr>
                        <td>${book.titulo}</td>
                        <td>${book.isbn}</td>
                        <td>${book.autor}</td>
                        <td>${book.categoria}</td>
                        <td>${book.fecha_publicacion}</td>
                        <td>${book.numero_paginas}</td>
                        <td>${book.idioma}</td>
                        <td>${book.created_at}</td>
                        <td>${book.updated_at}</td>
                        <td>
                            <button class="btn btn-sm btn-primary me-1" title="Ver" onclick='app.viewBook(${JSON.stringify(book)})'>
                                <i class="bi bi-eye-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-secondary me-1" title="Editar" onclick='app.showEditModal(${JSON.stringify(book)})'>
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Eliminar" onclick="app.deleteBook(${book.id})">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        $('#booksTable tbody').html(html);

    } catch (error) {
        console.error("Error cargando libros:", error);
        $('#booksTable tbody').html(`<tr><td colspan="5">Error al cargar libros.</td></tr>`);
        }
    },

    addBook: async function () {
    const form = document.getElementById('formAgregarLibro');
    const formData = new FormData(form);

    try {
        const response = await $.ajax({
            url: '/Books/addBook', // Asegúrate de que este endpoint exista en tu backend
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
        });

        console.log(response);

        // Cierra el modal, limpia el formulario y recarga los libros
        $('#modalAgregarLibro').modal('hide');
        form.reset();
        this.loadBooks();

        Swal.fire({
            icon: 'success',
            title: 'Libro agregado correctamente',
            showConfirmButton: false,
            timer: 1500
        });

    } catch (error) {
        console.error("Error al agregar el libro:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error al agregar el libro',
            text: error.responseJSON?.message || 'Ocurrió un error inesperado.'
        });
    }
},

    viewBook: function(book) {
        // Llenar campos del modal
        $('#verLibroImagen').attr('src', book.imagen || '/uploads/notfound.png');
        $('#verLibroGenero').text(book.categoria || 'Sin categoría');
        $('#verLibroTitulo').text(book.titulo);
        $('#verLibroAutor').text(`por ${book.autor}`);
        $('#verLibroAnio').text(book.fecha_publicacion);
        $('#verLibroPaginas').text(book.numero_paginas);
        $('#verLibroIsbn').text(book.isbn);
        $('#verLibroIdioma').text(book.idioma);
        $('#verLibroSinopsis').text(book.sinopsis || 'Sin sinopsis.');

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalVerLibro'));
        modal.show();
    },

    showEditModal: async function (book) {
    // Llenar select de autores y categorías
    const [autores, categorias] = await Promise.all([
        $.getJSON(this.routes.getAuthors),
        $.getJSON(this.routes.getCategories)
    ]);

    // Llenar select de autores
    const autorSelect = $('#editAutor');
    autorSelect.empty().append(`<option value="">Seleccione un autor</option>`);
    autores.forEach(autor => {
        autorSelect.append(`<option value="${autor.id}" ${autor.nombre_completo === book.autor ? 'selected' : ''}>${autor.nombre_completo}</option>`);
    });

    // Llenar select de categorías
    const categoriaSelect = $('#editCategoria');
    categoriaSelect.empty().append(`<option value="">Seleccione una categoría</option>`);
    categorias.forEach(cat => {
        categoriaSelect.append(`<option value="${cat.id}" ${cat.nombre_categoria === book.categoria ? 'selected' : ''}>${cat.nombre_categoria}</option>`);
    });

    // Rellenar los campos del formulario
    $('#editLibroId').val(book.id);
    $('#editTitulo').val(book.titulo);
    $('#editIsbn').val(book.isbn);
    $('#editFechaPublicacion').val(book.fecha_publicacion);
    $('#editIdioma').val(book.idioma);
    $('#editNumeroPaginas').val(book.numero_paginas);
    $('#editSinopsis').val(book.sinopsis);

    // Mostrar el modal
    $('#modalEditarLibro').modal('show');
    },

    deleteBook: async function (id) {
        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            try {
                const response = await $.ajax({
                    url: this.routes.deleteBook,
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json'
                });

                if (response.status) {
                    Swal.fire(
                        '¡Eliminado!',
                        'El libro ha sido eliminado.',
                        'success'
                    );
                    this.loadBooks();
                } else {
                    Swal.fire(
                        'Error',
                        'No se pudo eliminar el libro.',
                        'error'
                    );
                }
            } catch (error) {
                console.error("Error eliminando libro:", error);
                Swal.fire(
                    'Error',
                    'Ocurrió un error al eliminar el libro.',
                    'error'
                );
            }
        }
    },



    loadAuthors: async function () {
        try {
            const authors = await $.getJSON(this.routes.getAuthors);
            console.log(authors)

            let html = '';
            if (authors.length === 0) {
                html = `<tr><td colspan="5">No hay libros disponibles.</td></tr>`;
            } else {
                authors.forEach(author => {
                    html += `
                        <tr>
                            <td>${author.nombre_completo}</td>
                            <td>${author.nacionalidad}</td>
                            <td>${author.fecha_nacimiento}</td>
                            <td>${author.created_at}</td>
                            <td>${author.updated_at}</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-1" title="Editar">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#authorsTable tbody').html(html);

        } catch (error) {
            console.error("Error cargando autores:", error);
            $('#authorsTable tbody').html(`<tr><td colspan="5">Error al cargar autores.</td></tr>`);
        }
    },

    loadAuthorsSelect: async function () {
    try {
        const authors = await $.getJSON(this.routes.getAuthors);
        let options = '<option value="">Seleccione un autor</option>';

        authors.forEach(author => {
            options += `<option value="${author.id}">${author.nombre_completo}</option>`;
        });

        $('#selectAutor').html(options);
    } catch (error) {
        console.error("Error al cargar autores:", error);
        $('#selectAutor').html('<option>Error al cargar</option>');
    }
},

    loadCategoriesSelect: async function () {
    try {
        const categories = await $.getJSON(this.routes.getCategories);
        let options = '<option value="">Seleccione una categoría</option>';

        categories.forEach(category => {
            options += `<option value="${category.id}">${category.nombre_categoria}</option>`;
        });

        $('#selectCategoria').html(options);
    } catch (error) {
        console.error("Error al cargar categorías:", error);
        $('#selectCategoria').html('<option>Error al cargar</option>');
    }
},


    loadCategories: async function () {
        try {
            const categories = await $.getJSON(this.routes.getCategories);
            console.log(categories)

            let html = '';
            if (categories.length === 0) {
                html = `<tr><td colspan="5">No hay categorias disponibles.</td></tr>`;
            } else {
                categories.forEach(category => {
                    html += `
                        <tr>
                            <td>${category.nombre_categoria}</td>
                            <td>${category.descripcion}</td>
                            <td>${category.created_at}</td>
                            <td>${category.updated_at}</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-1" title="Editar" onclick='app.showEditModal(${JSON.stringify(category)})'>
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Eliminar" onclick="app.deleteCategory(${category.id})">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#categoriesTable tbody').html(html);

        } catch (error) {
            console.error("Error cargando categorias:", error);
            $('#categoriesTable tbody').html(`<tr><td colspan="5">Error al cargar categorias.</td></tr>`);
        }
    },

    addCategory: async function () {
        const categoryData = {
            nombre_categoria: $('#nombreCategoria').val(),
            descripcion: $('#descripcionCategoria').val()
        };

        try {
            const response = await $.ajax({
                url: this.routes.addCategory,
                type: 'POST',
                data: categoryData,
                dataType: 'json'
            });

            if (response.status) {
                Swal.fire('Categoria Creada!', 'La categoría fue creada con éxito.', 'success');
                this.loadCategories();
            } else {
                Swal.fire('Error', 'No se pudo crear la categoría.', 'error');
            }
        } catch (error) {
            console.error("Error guardando categoría:", error);
            alert('Error al guardar la categoría.');
        }
    },

    updateCategory: async function () {
    const data = {
        id: $('#editCategoriaId').val(),
        nombre_categoria: $('#editNombreCategoria').val(),
        descripcion: $('#editDescripcionCategoria').val()
    };

    try {
        const response = await $.ajax({
            url: this.routes.updateCategory,
            type: 'POST',
            data: data,
            dataType: 'json'
        });

        if (response.status) {
            Swal.fire('¡Actualizado!', 'La categoría fue actualizada con éxito.', 'success');
            $('#modalEditarCategoria').modal('hide');
            this.loadCategories();
        } else {
            Swal.fire('Error', 'No se pudo actualizar la categoría.', 'error');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Ocurrió un problema con la solicitud.', 'error');
    }
},


    deleteCategory: async function (id) {
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: '¡No podrás revertir esto!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (result.isConfirmed) {
        try {
            const response = await $.ajax({
                url: this.routes.deleteCategory,
                type: 'POST',
                data: { id: id },
                dataType: 'json'
            });

            if (response.status) {
                Swal.fire(
                    '¡Eliminado!',
                    'La categoría ha sido eliminada.',
                    'success'
                );
                this.loadCategories();
            } else {
                Swal.fire(
                    'Error',
                    'No se pudo eliminar la categoría.',
                    'error'
                );
            }
        } catch (error) {
            console.error("Error eliminando categoría:", error);
            Swal.fire(
                'Error',
                'Ocurrió un error al eliminar la categoría.',
                'error'
                );
            }
        }
    },

    loadAuthors: async function () {
        try {
            const response = await $.ajax({
                url: this.routes.getAuthors,
                type: 'GET',
                dataType: 'json'
            });
            const authors = response;
            console.log('Autores:', authors);

            let html = '';
            if (!authors || authors.length === 0) {
                html = `<tr><td colspan="6">No hay autores disponibles.</td></tr>`;
            } else {
                authors.forEach(author => {
                    html += `
                        <tr>
                            <td>${author.nombre_completo}</td>
                            <td>${author.nacionalidad}</td>
                            <td>${author.fecha_nacimiento}</td>
                            <td>${author.created_at}</td>
                            <td>${author.updated_at}</td>
                            <td>
                                <button class="btn btn-sm btn-primary me-1" title="Editar" onclick='app.showEditModal(${JSON.stringify(author)})'>
                                    <i class="bi bi-pencil-fill"></i>
                                </button> 
                                <button class="btn btn-sm btn-danger" title="Eliminar" onclick="app.deleteAuthor(${author.id})">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#authorsTable tbody').html(html);

        } catch (error) {
            console.error("Error cargando autores:", error);
            $('#authorsTable tbody').html(`<tr><td colspan="5">Error al cargar autores.</td></tr>`);
        }
    },
    
    addAuthor: async function () {
        const authorData = {
            nombre_completo: $('#nombreCompleto').val(),
            nacionalidad: $('#nacionalidad').val(),
            fecha_nacimiento: $('#fechaNacimiento').val()
        };

        try {
            const response = await $.ajax({
                url: this.routes.addAuthor,
                type: 'POST',
                data: authorData,
                dataType: 'json'
            });

            if (response.status) {
                // Mostrar alert de éxito
                Swal.fire({
                    title: 'Éxito',
                    text: 'Autor guardado exitosamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.loadAuthors();
                        // Cerrar modal
                        $('#modalAgregarAutor').modal('hide');
                        // Limpiar form
                        $('#nombreCompleto').val('');
                        $('#nacionalidad').val('');
                        $('#fechaNacimiento').val('');
                    }
                });
            } else {
                // Mostrar SweetAlert2 de error
                Swal.fire({
                    title: 'Error',
                    text: 'Error al guardar el autor',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        } catch (error) {
            console.error("Error guardando autor:", error);
            // Mostrar SweetAlert2 de error
            Swal.fire({
                title: 'Error',
                text: 'Error al guardar el autor',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    },
    
    deleteAuthor: async function (id) {
        try {
            // Mostrar SweetAlert2 de confirmación
            const result = await Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Deseas eliminar este autor?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });

            if (result.isConfirmed) {
                // Si el usuario confirma, proceder con la eliminación
                const response = await $.ajax({
                    url: this.routes.deleteAuthor,
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json'
                });

                if (response.status) {
                    // Mostrar mensaje de éxito
                    await Swal.fire({
                        title: 'Éxito',
                        text: 'Autor eliminado exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    // Recargar la lista de autores
                    this.loadAuthors();
                } else {
                    // Mostrar mensaje de error
                    await Swal.fire({
                        title: 'Error',
                        text: 'Error al eliminar el autor',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            }
        } catch (error) {
            console.error("Error eliminando autor:", error);
            await Swal.fire({
                title: 'Error',
                text: 'Error al eliminar el autor',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    },

    showEditModal: function (author) {
        try {
            // Poblar el formulario con los datos del autor
            $('#editAutorId').val(author.id);
            $('#editNombreCompleto').val(author.nombre_completo);
            $('#editNacionalidad').val(author.nacionalidad);
            $('#editFechaNacimiento').val(author.fecha_nacimiento);
            // Mostrar el modal
            $('#modalEditarAutor').modal('show');
        } catch (error) {
            console.error("Error mostrando modal:", error);
            Swal.fire({
                title: 'Error',
                text: 'Error al mostrar el modal de edición',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    },

    editAuthor: async function () {
        const data = {
            id: $('#editAutorId').val(),
            nombre_completo: $('#editNombreCompleto').val(),
            nacionalidad: $('#editNacionalidad').val(),
            fecha_nacimiento: $('#editFechaNacimiento').val()
        };

        try {
            const response = await $.ajax({
                url: this.routes.editAuthor,
                type: 'POST',
                data: data,
                dataType: 'json'
            });

            if (response.status) {
                Swal.fire('¡Actualizado!', 'El autor fue actualizado con éxito.', 'success');
                $('#modalEditarAutor').modal('hide');
                this.loadAuthors();
            } else {
                Swal.fire('Error', 'No se pudo actualizar el autor.', 'error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire('Error', 'Ocurrió un problema con la solicitud.', 'error');
        }
    }
}

        
