// 用于嵌入时，urlParams为空
window.urlParams = window.urlParams || {};

// 公共全局变量
window.MAX_REQUEST_SIZE = window.MAX_REQUEST_SIZE  || 10485760;
window.MAX_AREA = window.MAX_AREA || 15000 * 15000;

// 用于保存和导出的URL
window.EXPORT_URL = window.EXPORT_URL || '/export';
window.SAVE_URL = window.SAVE_URL || '/save';
window.OPEN_URL = window.OPEN_URL || '/open';
window.RESOURCES_PATH = window.RESOURCES_PATH || 'resources';
window.RESOURCE_BASE = window.RESOURCE_BASE || window.RESOURCES_PATH + '/grapheditor';
window.STENCIL_PATH = window.STENCIL_PATH || 'stencils';
window.IMAGE_PATH = window.IMAGE_PATH || 'images';
window.STYLE_PATH = window.STYLE_PATH || 'styles';
window.CSS_PATH = window.CSS_PATH || 'styles';
window.OPEN_FORM = window.OPEN_FORM || 'open.html';

// 通过url参数设置基本路径、用户界面语言并配置
// 支持的语言以避免404。加载所有核心语言
// 资源被禁用，因为所有必需的资源都在grapheditor中.
// 性质。注意，在这个例子中，加载两个资源
// 文件（特殊包和默认包）被禁用为
// 保存获取请求。这要求所有资源都存在于
// 每个属性文件，因为只加载一个文件.
window.mxBasePath = window.mxBasePath || '../../../src';
window.mxLanguage = window.mxLanguage || urlParams['lang'];
window.mxLanguages = window.mxLanguages || ['cn'];
