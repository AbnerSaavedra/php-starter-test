# Prueba de PHP - JIDA. 

 
### Descripción de la prueba

Se debe realizar una aplicación que permita a un usuario:

- Iniciar sesión
- Ver un listado de posts
- Crear nuevos posts
- Modificar posts
- Eliminar posts
- Cerrar sesíón.

Todas las acciones deberán realizarse por medio de consultas a una API y es requerido implementar 
una lógica de cache que compare si los registros consultados ya existen y si el valor "time_updated" de cada item es diferente, se deberá actualizar la información de cache del mismo a partir de la consulta, sino deberá mostrarse el listado de articulos desde la cache.

## Indicaciones

- [API](docs/api.md)

### Puntos de interes

  - Realizar fork de este repositorio y subir la prueba en un repositorio propio en github.  
  - Se deberá desarrollar una clase que permita realizar las multiples solicitudes a la API (metodos GET, POST, PUT y DELETE).
  - Se debe hacer uso de sesiones.
  - Se tendrá en cuenta la limpieza del código.
  - Se tendrán en cuenta las validaciones
  - Cada sección deberá tener una url independiente.
  