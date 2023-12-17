function toCamel(string) {
    let find = /(\_\w)/g
    let convert = function (matches) {
        return matches[1].toUpperCase()
    }
    return string.replace(find, convert)
}

function toSnake(string) {
    let find = /([A-Z])/g
    let convert = function (matches) {
        return '_' + matches.toLowerCase()
    }
    return string.replace(find, convert)
}

export default {
    toCamel,
    toSnake
}
