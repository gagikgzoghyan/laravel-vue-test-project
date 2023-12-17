import caseConverters from './case-converters'

function getClass(obj) {
    // Workaround for detecting native classes.
    // Examples:
    // getClass({}) === 'Object'
    // getClass([]) === 'Array'
    // getClass(function () {}) === 'Function'
    // getClass(new Date) === 'Date'
    // getClass(null) === 'Null'

    // Here we get a string like '[object XYZ]'
    const typeWithBrackets = Object.prototype.toString.call(obj)
    // and we extract 'XYZ' from it
    return typeWithBrackets.match(/\[object (.+)\]/)[1]
}

function convertObjectKeys(obj, keyConversionFun, ignoreKeys = []) {
    // Creates a new object mimicking the old one with keys changed using the keyConversionFun.
    // Does a deep conversion.
    // Taken from https://github.com/ZupIT/angular-http-case-converter
    if (getClass(obj) !== 'Object' && getClass(obj) !== 'Array') {
        return obj // Primitives are returned unchanged.
    }

    return Object.keys(obj).reduce((newObj, key) => {
        if (ignoreKeys.includes(key)) {
            newObj[key] = obj[key]
        } else {
            newObj[keyConversionFun(key)] = convertObjectKeys(obj[key], keyConversionFun)
        }

        return newObj
    }, Array.isArray(obj) ? [] : {}) // preserve "arrayness"
}

export default {
    toCamel: (o, ignoreKeys) => convertObjectKeys(o, caseConverters.toCamel, ignoreKeys),
    toSnake: (o, ignoreKeys) => convertObjectKeys(o, caseConverters.toSnake, ignoreKeys)
}
