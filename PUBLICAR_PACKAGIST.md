# 🚀 Guía Rápida: Publicar en Packagist

## ✅ Estado Actual

Tu paquete está **casi listo** para publicarse. Solo faltan estos pasos:

## 📋 Pasos para Publicar

### 1. Agregar URL del Repositorio en `composer.json`

Agrega el campo `repository` después del campo `license`:

```json
{
    "name": "adriceci/audit-center",
    ...
    "license": "MIT",
    "repository": {
        "type": "git",
        "url": "https://github.com/TU_USUARIO/audit-center.git"
    },
    "authors": [...]
}
```

**⚠️ IMPORTANTE**: Reemplaza `TU_USUARIO` con tu nombre de usuario de GitHub/GitLab.

### 2. Actualizar Email del Autor

En `composer.json`, cambia:
```json
"email": "your-email@example.com"
```
Por tu email real.

### 3. Preparar Repositorio Git

```bash
# Si no tienes Git inicializado
git init

# Añadir todos los archivos
git add .

# Primer commit
git commit -m "Initial commit: Laravel Audit Center package"

# Añadir remoto (reemplaza con tu URL)
git remote add origin https://github.com/TU_USUARIO/audit-center.git

# Push al repositorio
git push -u origin main

# Crear tag de versión inicial
git tag -a v1.0.0 -m "Versión inicial 1.0.0"
git push origin v1.0.0
```

### 4. Registrar en Packagist

1. Ve a [packagist.org](https://packagist.org) y crea una cuenta
2. Conecta tu cuenta de GitHub/GitLab
3. Ve a **"Submit"**
4. Pega la URL de tu repositorio: `https://github.com/TU_USUARIO/audit-center`
5. Packagist detectará automáticamente tu `composer.json`
6. Revisa los detalles y haz clic en **"Submit"**

### 5. Configurar Webhook (Automático)

Para que Packagist se actualice automáticamente cuando subas nuevos tags:

1. En GitHub: **Settings → Webhooks → Add webhook**
2. URL: `https://packagist.org/api/github?username=TU_USUARIO`
3. Content type: `application/json`
4. En Packagist: Ve a tu perfil → **Show API Token** → Copia el token
5. Agrega el token a la URL: `https://packagist.org/api/github?username=TU_USUARIO&apiToken=TU_TOKEN`

## ✅ Checklist Final

- [ ] `composer.json` tiene campo `repository` con URL correcta
- [ ] Email del autor actualizado
- [ ] Repositorio Git creado y subido a GitHub/GitLab
- [ ] Tag `v1.0.0` creado y pusheado
- [ ] Cuenta creada en Packagist
- [ ] Paquete registrado en Packagist
- [ ] Webhook configurado (opcional pero recomendado)

## 🧪 Probar la Instalación

Una vez publicado, prueba en otro proyecto Laravel:

```bash
composer require adriceci/audit-center
```

## 📝 Notas Importantes

- **El nombre del paquete** (`adriceci/audit-center`) debe ser único en Packagist
- **Una vez publicado, el nombre NO puede cambiarse**
- Cada nueva versión necesita un nuevo tag en Git (`v1.0.1`, `v1.1.0`, `v2.0.0`, etc.)
- Packagist detecta automáticamente nuevos tags si tienes webhook configurado

## 🔄 Proceso para Nuevas Versiones

```bash
# 1. Hacer cambios y commit
git add .
git commit -m "Descripción de cambios"

# 2. Crear nuevo tag
git tag -a v1.0.1 -m "Fix: descripción del fix"

# 3. Push cambios y tag
git push origin main
git push origin v1.0.1

# 4. Packagist se actualizará automáticamente (con webhook)
# O actualiza manualmente desde Packagist
```

## 📚 Archivos Incluidos

- ✅ `composer.json` - Configuración del paquete
- ✅ `LICENSE` - Licencia MIT
- ✅ `.gitignore` - Archivos ignorados
- ✅ `.gitattributes` - Excluye archivos innecesarios del paquete distribuido
- ✅ `README.md` - Documentación

## ❓ Problemas Comunes

**"Package not found"**
- Verifica que el repositorio sea público
- Verifica que hayas creado al menos un tag
- Espera 1-2 minutos para que Packagist actualice

**"Could not find package"**
- Verifica que el nombre en `composer.json` coincida exactamente
- Verifica que el tag esté pusheado al remoto

**"No valid composer.json"**
- Ejecuta `composer validate` para ver errores específicos

---

**¿Listo?** Una vez completados estos pasos, tu paquete estará disponible en Packagist y cualquiera podrá instalarlo con `composer require adriceci/audit-center` 🎉

