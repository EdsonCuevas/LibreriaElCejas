const app = {
    routes : {
        getBooks : "/Books/getBooks",
        getAuthors : "/Authors/getAuthors",
        getCategories : "/Categories/getCategories",
        addCategory : "/Categories/addCategory",
        addAuthor : "/Authors/addAuthor",
        deleteAuthor: "/Authors/deleteAuthor"
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

        $('#booksTable tbody').html(html);

    } catch (error) {
        console.error("Error cargando libros:", error);
        $('#booksTable tbody').html(`<tr><td colspan="5">Error al cargar libros.</td></tr>`);
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
                                <button class="btn btn-sm btn-primary me-1" title="Editar">
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
                alert('Categoría guardada exitosamente.');
                this.loadCategories();
            } else {
                alert('Error al guardar la categoría.');
            }
        } catch (error) {
            console.error("Error guardando categoría:", error);
            alert('Error al guardar la categoría.');
        }
    },

    deleteCategory : async function (id) {
        
        try {
            const response = await $.ajax({
                url: `/Categories/deleteCategory`,
                type: 'POST',
                data: { id: id },
                dataType: 'json'
            });

            if (response.status) {
                alert('Categoría eliminada exitosamente.');
                this.loadCategories();
            } else {
                alert('Error al eliminar la categoría.');
            }
        } catch (error) {
            console.error("Error eliminando categoría:", error);
            alert('Error al eliminar la categoría.');
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
            const response = await $.ajax({
                url: this.routes.deleteAuthor,
                type: 'POST',
                data: { id: id },
                dataType: 'json'
            });

            if (response.status) {
                Swal.fire({
                    title: 'Éxito',
                    text: 'Autor eliminado exitosamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.loadAuthors();
                        $('#modalAgregarAutor').modal('hide');
                        $('#nombreCompleto').val('');
                        $('#nacionalidad').val('');
                        $('#fechaNacimiento').val('');
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar el autor',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        } catch (error) {
            console.error("Error eliminando autor:", error);
            Swal.fire({
                title: 'Error',
                text: 'Error al eliminar el autor',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    }

}