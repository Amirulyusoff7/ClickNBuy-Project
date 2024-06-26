var style = document.createElement('style');
style.setAttribute("id", "multiselect_dropdown_styles");
style.innerHTML = `.multiselect-dropdown-list div.checked {}`;
document.head.appendChild(style);
var total=0, temp=0;
function MultiselectDropdown(options) {
  var config = {
    // search: true,
    height: '10rem',
    placeholder: 'Select Category',
    txtSelected: 'selected',
    // txtAll: 'All',
    ...options
  };
  function newEl(tag, attrs) {
    var e = document.createElement(tag);
    if (attrs !== undefined) Object.keys(attrs).forEach(k => {
      if (k === 'class') { Array.isArray(attrs[k]) ? attrs[k].forEach(o => o !== '' ? e.classList.add(o) : 0) : (attrs[k] !== '' ? e.classList.add(attrs[k]) : 0) }
      else if (k === 'style') {
        Object.keys(attrs[k]).forEach(ks => {
          e.style[ks] = attrs[k][ks];
        });
      }
      else if (k === 'text') { attrs[k] === '' ? e.innerHTML = '&nbsp;' : e.innerText = attrs[k] }
      else e[k] = attrs[k];
    });
    return e;
  }
 
 
  document.querySelectorAll("select[multiple]").forEach((el, k) => {
 
    var div = newEl('div', { class: 'multiselect-dropdown', style: { width: config.style?.width ?? el.clientWidth + 'px', padding: config.style?.padding ?? '' } });
    el.style.display = 'none';
    el.parentNode.insertBefore(div, el.nextSibling);
    
    var listWrap = newEl('div', { class: 'multiselect-dropdown-list-wrapper' });
    var list = newEl('div', { class: 'multiselect-dropdown-list', style: { height: config.height } });
    var search = newEl('input', { class: ['multiselect-dropdown-search'].concat([config.searchInput?.class ?? 'form-control']), style: { width: '100%', height: '35px', padding: '10px', display: el.attributes['multiselect-search']?.value === 'true' ? 'block' : 'none' }, placeholder: 'search' });
    
    
    listWrap.appendChild(search);
    div.appendChild(listWrap);
    listWrap.appendChild(list);
    
    
    
    el.loadOptions = () => {
      list.innerHTML = '';
     
    //   if (el.attributes['multiselect-select-all']?.value == 'true') {
        
    //     var op = newEl('div', { class: 'multiselect-dropdown-all-selector' })
    //     var ic = newEl('input', { type: 'checkbox' });
    //     op.appendChild(ic);
    //     op.appendChild(newEl('label', { text: config.txtAll }));
 
    //     op.addEventListener('click', () => {
    //       op.classList.toggle('checked');
    //       op.querySelector("input").checked = !op.querySelector("input").checked;
    //       var ch = op.querySelector("input").checked;
          
    //       list.querySelectorAll("input").forEach(i => i.checked = ch);
    //       Array.from(el.options).map(x => x.selected = ch);
 
    //       el.dispatchEvent(new Event('change'));
    //     });
    //     ic.addEventListener('click', (ev) => {
    //       ic.checked = !ic.checked;
          
    //     });
 
    //     list.appendChild(op);     
        
    //   }
 
      Array.from(el.options).map(o => {
        var op = newEl('div', { class: o.selected ? 'checked' : '', optEl: o })
        var ic = newEl('input', { type: 'checkbox', checked: o.selected });
        op.appendChild(ic);
        op.appendChild(newEl('label', { text: o.text }));
        
 
        op.addEventListener('click', () => {
            op.classList.toggle('checked');
            op.querySelector("input").checked = !op.querySelector("input").checked;
            
            // if(total==0) total=temp =1;
            // if()
            //total = el.selectedOptions.length;
            //document.getElementById('testing').innerHTML=total;

            op.optEl.selected = !!!op.optEl.selected;
            el.dispatchEvent(new Event('change'));
        });
        ic.addEventListener('click', (ev) => {
          ic.checked = !ic.checked;
        });
        list.appendChild(op);
      });
      div.listEl = listWrap;
 
      div.refresh = () => {
        
        div.querySelectorAll('span.optext, span.placeholder').forEach(t => div.removeChild(t));
        var sels = Array.from(el.selectedOptions);
        if (sels.length > (el.attributes['multiselect-max-items']?.value ?? 5)) {
          div.appendChild(newEl('span', { class: ['optext', 'maxselected'], text: sels.length + ' ' + config.txtSelected }));
        }
        else {
          sels.map(x => {
            var c = newEl('span', { class: 'optext', text: x.text });
            div.appendChild(c);
          });
        }
        if (0 == el.selectedOptions.length) div.appendChild(newEl('span', { class: 'placeholder', text: el.attributes['placeholder']?.value ?? config.placeholder }));
        if(el.selectedOptions.length > 2) {
            // alert("Please choose less than 2 categories");
            // var rm = document.getElementsByClassName('rows');
            // for(var i = 0; i<rm.length; i++) {
            //     rm[i].checked=false;
            // }
        }
      };
      div.refresh();
    }
    el.loadOptions();
 
    search.addEventListener('input', () => {
      list.querySelectorAll("div").forEach(d => {
        var txt = d.querySelector("label").innerText.toUpperCase();
        d.style.display = txt.includes(search.value.toUpperCase()) ? 'block' : 'none';
      });
    });
 
    div.addEventListener('click', () => {
      div.listEl.style.display = 'block';
      search.focus();
      search.select();
    });
 
    document.addEventListener('click', function (event) {
      if (!div.contains(event.target)) {
        listWrap.style.display = 'none';
        div.refresh();
      }
    });
  });
}
 
window.addEventListener('load', () => {
  MultiselectDropdown(window.MultiselectDropdownOptions);
  
});