const app = {
    routes : {
        getBooks : "/Books/getBooks",
        getAuthors : "/Authors/getAuthors",
        getCategories : "/Categories/getCategories",
        addCategory : "/Categories/addCategory",
        deleteCategory : "/Categories/deleteCategory",
        updateCategory : "/Categories/updateCategory",
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
                            <button class="btn btn-sm btn-secondary me-1" title="Editar">
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

        $('#booksTable tbody').html(html);

    } catch (error) {
        console.error("Error cargando libros:", error);
        $('#booksTable tbody').html(`<tr><td colspan="5">Error al cargar libros.</td></tr>`);
        }
    },

    viewBook: function(book) {
        // Llenar campos del modal
        $('#verLibroImagen').attr('src', book.imagen || 'uploads/notfound.png');
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




    
}