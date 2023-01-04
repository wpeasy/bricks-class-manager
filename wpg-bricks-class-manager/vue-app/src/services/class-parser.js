
export const getClassTag = className => {
    let type = "B"; /* Default to Block */


    if(className.startsWith('#')){ return '#'}

    className = className.replace('.', '');
    if(className.includes('__')){ type = 'E'}
    if(className.includes('--')){ type = 'M'}
    if(className.startsWith('u-') || className.startsWith('util-')){ type = 'U'}
    if(className.startsWith('fu-') || className.startsWith('f-') || className.startsWith('x-')){ type = 'F'}
    if(className.startsWith('bu-') || className.startsWith('b-')){ type = 'BU'}
    if(className.startsWith('x-')){ type = 'X'}

    return type;
}