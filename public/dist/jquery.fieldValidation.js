function validateField ({element, target, errText = "Please fill out this field.", isError = false}) {
 
  const newElement = $(element)
  clearValidation(newElement.attr('name'), target, newElement)
  if(isError) {
    addError(newElement , errText, target)
    return true
  }
  
  if(newElement.val() == "") {
    addError(newElement , errText, target)
    return true
  }
  // console.log(props)
  return false
}

function addError (newElement , errText, target) {
  var errElement = $(`<label class="mp-input-group__label red-clr" data-set="${target}" err-name="${newElement.attr('name')}">${errText}</label>`);
  if(newElement.prop("tagName") == "INPUT") {
    newElement.addClass("input-error")
  }
  if(newElement.prop("tagName") == "SELECT") {
    newElement.addClass("select-error")
  }
  newElement.after(errElement)
}

function clearValidation (name, target, element) {
  element.removeClass('select-error').removeClass('input-error')
  $(`[data-set=${target}][err-name=${name}]`).remove()
}