#IMPORTAMOS LOS PAQUETES DE FLASK
from flask import Flask, render_template, request

#IMPORTAR LAS FUNCIONES PARA GENERAR HASHES DE LA CONTRASEÑA Y COMPROBAR SI UNA CONTRASEÑA COINCIDE CON EL HASH
from werkzeug.security import generate_password_hash, check_password_hash

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
        password_hash = request.form["password_hash"]
        id_rol = request.form["id_rol"]

        pasword_hasheada = generate_password_hash(password_hash)

#INICIAMOS EL SERVIDOR FLASK EN EL PUERTO 5000
if __name__ == "__main__":
    app.run(port=5000)