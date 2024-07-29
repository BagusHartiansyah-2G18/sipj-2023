import { useState } from 'react';

function useInput(defaultValue = '') {
  const [value, setValue] = useState(defaultValue);

  function handleValueChange({ target }) {
    setValue(target.value);
  }

  return [value, handleValueChange, setValue];
}

function useInputInner(defaultValue = '') {
  const [value, setValue] = useState(defaultValue);

  function handleValueChange({ target }) {
    setValue(target.innerHTML);
  }

  return [value, handleValueChange, setValue];
}

export {
  useInput,
  useInputInner,
};
