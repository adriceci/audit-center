# Requerimientos para Publicar en Packagist

Esta guía detalla todos los requisitos necesarios para publicar tu paquete `adriceci/audit-center` en Packagist y poder instalarlo mediante `composer require`.

## ✅ Requerimientos Esenciales

### 1. **Repositorio Git Público**

- Tu código debe estar en un repositorio Git (GitHub, GitLab, Bitbucket, etc.)
- El repositorio debe ser **público** (o debes configurar autenticación en Packagist)
- URL del repositorio: `https://github.com/adriceci/audit-center` (ajusta según tu repositorio)

### 2. **composer.json Válido**

Tu `composer.json` debe incluir:

- ✅ `name`: "vendor/package-name" (ya tienes: `adriceci/audit-center`)
- ✅ `description`: Descripción del paquete
- ✅ `type`: "library" (ya lo tienes)
- ✅ `license`: Licencia válida (ya tienes: "MIT")
- ✅ `authors`: Información del autor (actualiza el email)
- ✅ `require`: Dependencias mínimas (ya las tienes)
- ✅ `autoload`: Configuración PSR-4 (ya la tienes)
- ⚠️ **FALTA**: Campo `repository` con la URL del repositorio Git

### 3. **Archivo LICENSE**

- ✅ Ya tienes el archivo LICENSE con licencia MIT

### 4. **Tags de Versión en Git**

Packagist usa los tags de Git para versionar tu paquete:

```bash
# Crear tu primera versión
git tag -a v1.0.0 -m "Versión inicial 1.0.0"
git push origin v1.0.0

# Para versiones futuras
git tag -a v1.0.1 -m "Fix: corrección de bug"
git push origin v1.0.1
```

**Formato recomendado**: `v1.0.0`, `v1.0.1`, `v2.0.0`, etc.

### 5. **Archivo .gitignore**

- ✅ Ya tienes un `.gitignore` apropiado

### 6. **Archivo .gitattributes (Recomendado)**

Para excluir archivos innecesarios del paquete distribuido en Packagist (reduce el tamaño).

## 📋 Checklist Pre-Publicación

### Paso 1: Actualizar composer.json

- [ ] Agregar campo `repository` con URL del repositorio
- [ ] Actualizar email del autor (actualmente: `your-email@example.com`)
- [ ] Verificar que todos los campos requeridos estén presentes

### Paso 2: Preparar Repositorio Git

- [ ] Inicializar repositorio Git (si no está inicializado)
- [ ] Hacer commit de todos los archivos
- [ ] Subir a GitHub/GitLab/Bitbucket
- [ ] Crear primer tag de versión (v1.0.0)
- [ ] Push del tag al repositorio remoto

### Paso 3: Validar composer.json

```bash
# Validar que el composer.json es válido
composer validate

# Probar la instalación localmente
composer require adriceci/audit-center:dev-main
```

### Paso 4: Crear Cuenta en Packagist

- [ ] Registrarse en https://packagist.org
- [ ] Conectar cuenta con GitHub/GitLab
- [ ] Ir a "Submit" y pegar la URL del repositorio
- [ ] Packagist detectará automáticamente el `composer.json`
- [ ] Revisar y confirmar los detalles del paquete
- [ ] Hacer clic en "Submit"

### Paso 5: Configurar Webhook (Recomendado)

Para actualizaciones automáticas cuando subas nuevos tags:

1. En tu repositorio GitHub, ve a **Settings → Webhooks**
2. Agrega webhook: `https://packagist.org/api/github?username=TU_USUARIO`
3. En Packagist, ve a tu perfil → **Show API Token**
4. Usa ese token en la URL del webhook

## 🔧 Configuraciones Opcionales pero Recomendadas

### 1. **Archivo .gitattributes**

Para excluir archivos de desarrollo del paquete distribuido.

### 2. **Archivo CHANGELOG.md**

Documentar cambios entre versiones.

### 3. **Tests**

Aunque no es obligatorio, es muy recomendado tener tests.

### 4. **CI/CD**

GitHub Actions para ejecutar tests automáticamente.

## 📦 Proceso de Publicación Completo

```bash
# 1. Validar composer.json
composer validate

# 2. Asegurarse de que todo está commiteado
git status

# 3. Commit de cambios finales (si hay)
git add .
git commit -m "Prepare package for Packagist"

# 4. Push al repositorio remoto
git push origin main

# 5. Crear tag de versión
git tag -a v1.0.0 -m "Versión inicial 1.0.0"
git push origin v1.0.0

# 6. Ir a Packagist.org y registrar el paquete
# 7. Una vez registrado, probar instalación en otro proyecto:
composer require adriceci/audit-center
```

## ⚠️ Errores Comunes

1. **"Package not found"**

   - Verifica que el repositorio sea público
   - Verifica que hayas creado al menos un tag
   - Espera unos minutos para que Packagist actualice

2. **"Could not find package"**

   - Verifica que el nombre en `composer.json` coincida exactamente
   - Verifica que el tag esté pusheado al remoto

3. **"No valid composer.json"**
   - Ejecuta `composer validate` para ver errores
   - Verifica que todos los campos requeridos estén presentes

## 📝 Notas Importantes

- El nombre del paquete en `composer.json` (`adriceci/audit-center`) debe ser único
- Una vez publicado, el nombre NO puede cambiarse
- Cada versión debe tener un tag único en Git
- Packagist actualiza automáticamente cuando detecta nuevos tags (con webhook)
- Sin webhook, debes actualizar manualmente desde Packagist

## 🚀 Después de Publicar

Una vez publicado, otros desarrolladores podrán instalar tu paquete con:

```bash
composer require adriceci/audit-center
```

Para versiones específicas:

```bash
composer require adriceci/audit-center:^1.0
composer require adriceci/audit-center:^2.0
```
