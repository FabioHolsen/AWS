import pymysql
import os
import json

# Leer variables de entorno
DB_HOST = os.getenv('DB_HOST')
DB_USER = os.getenv('DB_USER')
DB_PASSWORD = os.getenv('DB_PASSWORD')
DB_NAME = os.getenv('DB_NAME')

def lambda_handler(event, context):
    """
    Lambda para insertar un producto en MySQL desde API Gateway.
    Espera un JSON en el body con: nombre, color, descripcion, precio
    """
    try:
        # Parsear el body del request (JSON)
        body = json.loads(event.get('body', '{}'))

        # Validar campos obligatorios
        required_fields = ['nombre', 'color', 'descripcion', 'precio']
        missing_fields = [f for f in required_fields if f not in body]
        if missing_fields:
            return {
                'statusCode': 400,
                'body': json.dumps({
                    'error': f'Faltan campos obligatorios: {", ".join(missing_fields)}'
                })
            }

        # Validar tipo de precio
        try:
            body['precio'] = float(body['precio'])
        except ValueError:
            return {
                'statusCode': 400,
                'body': json.dumps({'error': 'El campo precio debe ser un número'})
            }

        # Conectar a MySQL
        connection = pymysql.connect(
            host=DB_HOST,
            user=DB_USER,
            password=DB_PASSWORD,
            database=DB_NAME,
            cursorclass=pymysql.cursors.DictCursor
        )

        with connection.cursor() as cursor:
            sql = "INSERT INTO producto (nombre, color, descripcion, precio) VALUES (%s, %s, %s, %s)"
            cursor.execute(sql, (
                body['nombre'],
                body['color'],
                body['descripcion'],
                body['precio']
            ))
            connection.commit()

        return {
            'statusCode': 200,
            'body': json.dumps({'message': f"Producto '{body['nombre']}' insertado correctamente."})
        }

    except Exception as e:
        return {
            'statusCode': 500,
            'body': json.dumps({'error': str(e)})
        }

    finally:
        if 'connection' in locals() and connection:
            connection.close()
