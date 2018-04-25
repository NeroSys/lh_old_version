import {OptionGroup} from "./option-group";
import {VariantCollection} from "./variant-collection";
import {Option} from "./option";
import {FormControl, FormGroup, FormArray} from "@angular/forms";

export class FormFields {
    public fields: OptionGroup[] = [];
    private form: FormGroup[];

    constructor() {
        // this.form['quantity'] = new FormGroup({});
    }

    public setData(variants: VariantCollection):void {
        variants.getAll().forEach(variant => {
            variant.options.forEach(
                option => {
                    this.setOptionItem(option);
                    this.setFormControl(option);
                }
            );
        });
    }

    public getData(): FormGroup[] {
        return this.form;
    }

    private setOptionItem(option: Option): void {

        const group_index = this.fields.findIndex(item => option.option_id === item.option_id);
        if (group_index < 0) {
            this.fields.push({
                option_id: option.option_id,
                option_name: option.option_name,
                product_option_id: option.product_option_id,
                type: option.type,
                status: true,
                values: [option]
            });
        } else {
            if (!this.fields[group_index].values.find(item => item.option_value_id === option.option_value_id)) {
                this.fields[group_index].values.push(option);
            }
        }
    }

    private setFormControl(option: Option): void {
        // console.log(this.form);
        let field = 'field_' + option.option_id;
        if (this.form[field] === undefined) {
            this.form[field] = new FormGroup({
                field: new FormArray([
                    new FormControl(option.option_value_id)
                ])
            });
        } else {
            this.form[field].controls[field].setValue(option.option_value_id);
        }

        console.log(this.form);
    }


}