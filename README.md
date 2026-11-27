# Prueba-Técnica

MySQL user root, password debian, db trabajadores, table empleados

'admin'@'localhost' 'c123'

El proyecto se realizo en una maquina virtual con Debian 13.7.0 como su sitema operativo y con interfaz gráfica, se le instalo las paqueterias de: php-cli, apache2, MySQL que viene como un repositorio (ttps://repo.mysql.com//mysql-apt-config_0.8.32-1_all.deb), ya que no hay paquetria apt de mysql para Debian 13 y MySQLi para la conxión entre PHP y MySQL.

El Apartado de MySQL por medio de root se creo la BD 'trabajadores', la tabla dentro de esta BD 'empleados' y al usuario que tiene todos los privilegios para trabajar con la tabla 'admin'@'localhost' con su contraseña 'c123'

Se creo la tabla con 8 atributos, uno adicional a los requeridos por ser el necesario para apoyarnos en busquedas u organización y el desarrollo de funciones "PROCEDURE" que realizan todos los Query que necesitamos para trabajar con PHP.

En la parte de PHP para la conexión entre MySQL y la página web haciendo llamadas a las PROCEDURE.

La sección de HTML que organiza áreas para ingresar los datos de los empleados

---PARTES FALTANTES---

Realice pruebas y no conecta a la base de datos, al momento de mandar datos corre un error en los datos y estos no presentan nda, mantiene los datos dentro de las casillas, ademas la tabla que deberia de mostrarse paramostrar los datos que van ingresando no muestra nda por lo mismo, es más un fallo de la conexión entre la BD y PHP a mi parecer que de html o podría ser la mismaa ágina web, (faltan más pruebas).

Me guie bastante haciendo uso de la IA para saber cómo tenia que crear tanto los PROCEDURES, como el apartado de PHP y HTML, fuí modificandolo según lo requeria para cumplir los requerimentos del proyecto.
