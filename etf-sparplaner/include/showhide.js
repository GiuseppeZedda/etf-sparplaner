/**
 * 
 */
function show_elements()
{
    var elementNames = show_elements.arguments;
    for (var i=0; i<elementNames.length; i++)
    {
        var elementName = elementNames[i];
        document.getElementById(elementName).style.display='block';
    }
}
function hide_elements()
{
    var elementNames = hide_elements.arguments;
    for (var i=0; i<elementNames.length; i++)
    {
        var elementName = elementNames[i];
        document.getElementById(elementName).style.display='none';
    }
}
function show_elements_class()
{
    var elementNames = show_elements.arguments;
    for (var i=0; i<elementNames.length; i++)
    {
        var elementName = elementNames[i];
        document.getElementsByClassName(elementName).style.display='block';
    }
}