// Добавляем GET параметры
function setUrlParam(param, value) {
    const url = new URL(window.location);
    url.searchParams.delete(param);
    url.searchParams.append(param, value);
    window.history.pushState({}, null, url);
}
