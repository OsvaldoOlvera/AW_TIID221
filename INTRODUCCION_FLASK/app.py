#IMPORTAMOS LOS PAQUETES DE FLASK
from flask import Flask, render_template, request, redirect , url_for, session

#IMPORTAR LAS FUNCIONES PARA GENERAR HASHES DE LA CONTRASEÑA Y COMPROBAR SI UNA CONTRASEÑA COINCIDE CON EL HASH
from werkzeug.security import generate_password_hash, check_password_hash

from flask_mysqldb import MySQL

#CREAMOS UNA INSTANCIA DE NUESTRA APLICACION
app = Flask (__name__)

#CONFIGURACION DE LA CONEXIÓN
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'FlaskDB'

#PERMITE QUE FLASK VUELVA A CARGAR LAS PLANTILLAS CUANDO SE MODIFICAN 
app.config['TEMPLATES_AUTO_RELOAD'] = True
app.secret_key = 'mysecretkey'
mysql = MySQL(app)

#CREACIÓN DE RUTA. LA RUTA / ES LA RUTA RAÍZ, SÉRA LA QUE SE MOSTRARÁ CUANDO EL PROYECTO SE EJECUTE
@app.route("/")
def home():
    #ESTAMOS RETORNANDO UNA VISTA HTML DE LA CARPETA TEMPLATES
    return render_template("login.html")

@app.route("/registro", method=["GET","POST"])
def registro():
    if request.method == "POST":
        nombre = request.form["nombre"]
        a_paterno = request.form["a_paterno"]
        a_materno = request.form["a_materno"]
        correo = request.form["correo"]
        password = request.form["password"]
        id_rol = request.form["id_rol"]

        #VAMOS A GENERAR UN HASH A PARTIR DE LA CONTRASEÑA
        password_hash = generate_password_hash(password)

        cursor = mysql.connection.cursor()

        cursor.execute(
            "SELECT id FROM usuarios WHERE correo = %s",
            (correo,)
        )

        if cursor.fetchone():
            cursor.close()

            return render_template(
                "registro.html"
            )

        #INSERTAR REGISTRO A LA BD 
        cursor.execute(
            """INSERT INTO usuarios
            (nombre, a_paterno, a_materno, correo, password, id_rol)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            (nombre,
             a_paterno,
             a_materno,
             correo,
             password_hash,
             id_rol
             )
        )

        mysql.connection.commit()

        cursor.close()

        #CON URL _FOR NOS MANDA A LA RUTA QUE TIENE POR NOMBRE
        return redirect(url_for("home"))
    return render_template("registro")

#RUTA DE LOGIN
@app.route("/login", method=["GET", "POST"])
def login():

    if request.method == "POST":

        #VERIFICAMOS SI SE ENVIARON LOS DATOS AL FORMULARIO
        correo = request.form["correo"]
        password = request.form["password"]
        #CREAMOS EL CURSOR PARA EJECUTAR A CONSULTA SQL
        cursor = mysql.connection.cursor()

        #CONSULTA PARA BUSCAR AL USUARIO POR SU CORREO
        sql = """
            SELECT
            usuarios.id,
            usuarios.nombre,
            usuarios.a_paterno,
            usuarios.a_materno,
            usuarios.correo,
            usuarios.password
            roles.nombre
            FROM usuarios
            INNR JOIN id_rol
            ON usuarios.id_rol = roles.id_rol
            WHERE usuarios.correo = %s
            """
        #VAMOS A EJECUTAR LA CONSULTA PASANDO COMO PARAMETRO EL CORREO
        cursor.execute(sql, (correo,))

        usuario = cursor.fetchone()

        cursor.close()

        #VAMOS A VERIFICAR QUE LA CONTRASEÑA COINCIDA CON EL HASH 
        if usuario and check_password_hash(usuario[5], password):

            session["id_usuario"] = usuario[0]

            session["nombre"] = usuario[1]

            session["rol"] = usuario[6]

            if session["rol"] == "Administrador":
                return redirect(url_for("admin"))

            return redirect(url_for("usuario"))
        return render_template("login.html")

    #RUTA DE ADMINISTRADOR
    @app.route("/admin")
    def admin():
        #SI NO HAY UNA SESSION ACTIVA LO MANDA A LOGIN
        if "id_usuario" not in session:
            return redirect(url_for("login"))

        #Si el rol es diferente de Administrador, retornara un mensaje  de acceso denegado
        if session.get("rol") != "Administrador":
            return "Acceso Denegado"
        return render_template(
            "Administrador.html", 
            nombre=session["nombre"])


#INICIAMOS EL SERVIDOR FLASK EN EL PUERTO 5000
if __name__ == "__main__":
    app.run(port=5000)