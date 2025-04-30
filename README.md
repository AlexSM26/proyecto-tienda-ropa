# Tienda de Ropa - Base de Datos
**Primera parte del proyecto**: Este es un proyecto universitario donde primero se creo una base de datos para gestionar una tienda de ropa, donde nos incluye informacion sobre marcas, los tipo de ropa, las ventas y mas.

## Estructura de la Base de Datos
La base de datos esta estructurada con diferentes tablas donde guardamos informacion de nuestra tienda de ropa.

### :calendar: Tablas:
1. **marcas**: Muestra la información de las marcas.
2. **tipo_de_ropa**: Muestra la informacion del tipo de ropa.
3. **ventas**: Muestra el registro de las ventas.
4. **clientes**: Muestra la información sobre los clientes.
5. **detalle_ventas**: Muestra el detalle de cada venta.

### :mag_right: Vistas:

1. **marcas_con_ventas**: Muestra las marcas que tienen al menos una venta.
2. **prendas_vendidas_stock**: Muestra la cantidad de tipo de ropa vendida y su stock restante.
3. **top_5_marcas_vendidas**: Muestra las 5 marcas más vendidas.

## Diagrama de la Base de Datos
![image](https://github.com/user-attachments/assets/55a12031-5fd7-4726-88d4-bcce3d2847fb)


## Segunda parte del proyecto

Se crearon dos carpetas nuevas en el proyecto, una llamada API que contiene el backend de nuestro codigo y la otra llamada frontend que contiene la parte visual de nuestro proyecto, en el backend se crearon los modelos y los controladores, los modelos se van a encargar de interactuar con la base de datos para manejar la informacion de los productos y los controladores van a gestionar las peticiones del usuario, tambien se creo la el archivo routes.php que va a contener las rutas de los productos.

## Uso de los Endpoints de la API

1. 👤 Endpoints para obtener todos los clientes:
   - Método: GET
   - Endpoint: `http://localhost/proyecto/API/public/index.php/api/clientes/`
   - Descripción: Obtiene una lista de todos los usuarios registrados en el sistema.


   ```http
   GET http://localhost/proyecto/API/public/index.php/api/clientes
   ```

   Ejemplo de respuesta:
   ```json
   [
     {
        "id": 1,
        "nombre": "figuerez",
        "email": "figuerez@gmail.com",
        "telefono": "20303030",
        "direccion": "pejibaye"
     },
     {
        "id": 2,
        "nombre": "Maria Lopez",
        "email": "maria.lopez@gmail.com",
        "telefono": "88549203",
        "direccion": "Cartago"
     }
        {
        "id": 3,
        "nombre": "Carlos Gomez",
        "email": "carlos.gomez@gmail.com",
        "telefono": "88975430",
        "direccion": "Pejibaye"
     }
   ]
   ```

1. Endpoint para obtener un cliente por ID:
   - Método: GET
   - Endpoint: `http://localhost/proyecto/API/public/index.php/api/clientes/{id-del-cliente}`
   - Descripción: Obtiene la información de un cliente específico usando su ID.

   ```http
   GET http://localhost/proyecto/API/public/index.php/api/clientes/{id-del-cliente}
   ```

   Ejemplo de uso:
   ```http
   GET http://localhost/proyecto/API/public/index.php/api/clientes//1
   ```

   Ejemplo de respuesta:
   ```json
   {
    "id": 1,
    "nombre": "figuerez",
    "email": "figuerez@gmail.com",
    "telefono": "20303030",
    "direccion": "pejibaye"
   }
   ```
3. Endpoint para insertar un cliente:
   - Método: POST
   - Endpoint: `http://localhost/proyecto/API/public/index.php/api/clientes/`
   - Descripción: Inserta un nuevo cliente en la base de datos.

   ```http
   POST http://localhost/proyecto/API/public/index.php/api/clientes/
   ```

   Cuerpo de la petición (JSON):
   ```json
    {
        "nombre": "ariana",
        "email": "ariana@gmail.com",
        "telefono": "20303030",
        "direccion": "pejibaye"
    }
   ```

Respuesta
   ```json
   {
      "message": "Se ingreso un nuevo cliente de forma correcta"
   }
   ```

4. Endpoint para actualizar los datos de un cliente por ID:
   - Método: PUT
   - Endpoint: `http://localhost/proyecto/API/public/index.php/api/clientes/{id-del-cliente}`
   - Descripción: Actualiza la información de un cliente específico.

   ```http
   PUT http://localhost/proyecto/API/public/index.php/api/clientes/{id-del-cliente}
   ```

   Cuerpo de la petición (JSON):
   ```json
   {
        "nombre": "ariana marcela",
        "email": "arianamarcela@gmail.com",
        "telefono": "30202020",
        "direccion": "Mexico"
    }
   ```

Respuesta
   ```json
   {
      "message": "Cliente actualizado"
   }
   ```

5. Endpoint para eliminar un cliente por ID:
   - Método: DELETE
   - Endpoint: ` http://localhost/proyecto/API/public/index.php/api/clientes/{id-del-cliente}`
   - Descripción: Elimina un cliente en específico de la base de datos.

   ```http
   DELETE  http://localhost/proyecto/API/public/index.php/api/clientes/{id-del-cliente}
   ```

Respuesta
   ```json
   {
      "message": "Cliente eliminado"
   }
   ```

## Otros Endpoints del Proyecto  

### 🛒 Ventas  
**🔹 Endpoint:**  
`http://localhost/proyecto/API/public/index.php/api/ventas`

**🔹 Métodos:**  

- **📥 GET:** Obtener todas las ventas  
  `GET http://localhost/proyecto/API/public/index.php/api/ventas/`

- **➕ POST:** Crear una nueva venta  
  `POST http://localhost/proyecto/API/public/index.php/api/ventas`

- **📝 PUT:** Actualizar una venta por ID  
  `PUT http://localhost/proyecto/API/public/index.php/api/ventas/1`

- **🗑️ DELETE:** Eliminar una venta por ID  
  `DELETE http://localhost/proyecto/API/public/index.php/api/ventas/1`

---

### 👕 Tipo de Ropa  
**🔹 Endpoint:**  
`http://localhost/proyecto/API/public/index.php/api/tipo_ropa`

**🔹 Métodos:**  

- **📥 GET:** Obtener todos los tipos de ropa  
  `GET http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa`

- **➕ POST:** Crear un nuevo tipo de ropa  
  `POST http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa`

- **📝 PUT:** Actualizar un tipo de ropa por ID  
  `PUT http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa/1`

- **🗑️ DELETE:** Eliminar un tipo de ropa por ID  
  `DELETE http://localhost/proyecto/API/public/index.php/api/tipo_de_ropa/1`

---

### 🏷️ Marcas  
**🔹 Endpoint:**  
`http://localhost/proyecto/API/public/index.php/api/marcas`

**🔹 Métodos:**  

- **📥 GET:** Obtener todas las marcas  
  `GET http://localhost/proyecto/API/public/index.php/api/marcas/`

- **➕ POST:** Crear una nueva marca  
  `POST http://localhost/proyecto/API/public/index.php/api/marcas`

- **📝 PUT:** Actualizar una marca por ID  
  `PUT http://localhost/proyecto/API/public/index.php/api/marcas/1`

- **🗑️ DELETE:** Eliminar una marca por ID  
  `DELETE http://localhost/proyecto/API/public/index.php/api/marcas/1`

---

### 📄 Detalle de Ventas  
**🔹 Endpoint:**  
`http://localhost/proyecto/API/public/index.php/api/detalle_ventas`

**🔹 Métodos:**  

- **📥 GET:** Obtener todos los detalles de ventas  
  `GET http://localhost/proyecto/API/public/index.php/api/detalle_ventas/`

- **➕ POST:** Crear un nuevo detalle de venta  
  `POST http://localhost/proyecto/API/public/index.php/api/detalle_ventas`

- **📝 PUT:** Actualizar un detalle de venta por ID  
  `PUT http://localhost/proyecto/API/public/index.php/api/detalle_ventas/1`

- **🗑️ DELETE:** Eliminar un detalle de venta por ID  
  `DELETE http://localhost/proyecto/API/public/index.php/api/detalle_ventas/1`

---

### 📊 Reportes  
**🔹 Endpoint:**  
`http://localhost/proyecto/API/public/index.php/api/reportes`

**🔹 Métodos:**  

- **📥 GET:** Obtener las marcas que tienen al menos una venta  
  - **Descripción:** Devuelve una lista de marcas que han registrado ventas.  
  - **URL:** `GET http://localhost/proyecto/API/public/index.php/api/reportes/marcas-con-ventas`  

- **📥 GET:** Obtener las prendas vendidas y la cantidad disponible en stock  
  - **Descripción:** Muestra cuántas unidades de cada prenda se han vendido y cuántas quedan en stock.  
  - **URL:** `GET http://localhost/proyecto/API/public/index.php/api/reportes/prendas-vendidas-stock`  

- **📥 GET:** Obtener el top 5 de marcas más vendidas y la cantidad vendida  
  - **Descripción:** Devuelve las 5 marcas con mayor número de ventas junto con la cantidad vendida.  
  - **URL:** `GET http://localhost/proyecto/API/public/index.php/api/reportes/top-5-marcas-vendidas`  

