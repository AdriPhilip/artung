<template>
  <div class="fond">
    <FormGroupInline
      icon-status="twitter"
    />
    <FormGroup
      type-status="text"
      contenu="test"
      text="blabla"
    />
    <Checkbox />
    <TextButton
      secondary
      form
    />
    <EditIcon />
    <LoginButton />
    <AccountButton />
    <p />
    <FormAccount />
  </div>  
</template>

<script>
import TextButton from "../../components/buttons/TextButton";
import Checkbox from "../../components/forms/Checkbox";
import FormGroup from "../../components/forms/FormGroup";
import FormGroupInline from "../../components/forms/FormGroupInline";
import EditIcon from "../../components/buttons/EditIcon";
import LoginButton from "../../components/buttons/LoginButton"
import AccountButton from "../../components/buttons/AccountButton"
import FormAccount from "../../components/forms/FormAccount"

export default {
  name: "Steve",
  components: {
    FormGroup,
    Checkbox,
    TextButton,
    FormGroupInline,
    EditIcon,
    LoginButton,
    AccountButton,
    FormAccount
  },
  data() {
    return {
      typeStatus: "text mais il s'en fout..."
    };
  }
};
</script>

<style scoped lang="scss">
.fond {
  background: #131b23;
}
</style>
