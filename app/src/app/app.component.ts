import {Component, OnInit} from '@angular/core';
import {FormGroup, FormControl} from '@angular/forms';
import {MainService} from './app.service';
import {Specification} from './model/specification';
import {Option} from './model/option';


declare var product_id: any;

@Component({
    selector: 'app-product-options',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
    public form: FormGroup;
    public optionGroups;
    public data: object = {};
    private variants: Specification[];
    private selectedOptions: object = {};

    constructor(private mainService: MainService) {
        this.optionGroups = [];
        this.form = new FormGroup({});
        this.form.controls['quantity'] = new FormControl();
    }

    ngOnInit(): void {
        this.mainService
            .getSpecifications(product_id)
            .then(
                variants => this.variants = variants
            ).then(
            e => this.setOptionGroup()
        );
    }

    public select(option_id): void {
        this.setSelectedOptions();
        this.enableAnotherGroup(option_id);
        this.setVariantsStatus();
    }

    public onSubmit(): void {
        if (this.form.valid) {
            const request = {};
            console.log('selectedOptions: ', this.selectedOptions);
            request['quantity'] = this.form.controls.quantity.value;
            request['product_id'] = product_id;
            request['option'] = [];

            let body = 'quantity=' + this.form.controls.quantity.value;
            body += '&product_id=' + product_id;

            this.optionGroups.forEach(
                variant => {
                    if (this.selectedOptions[variant.option_id]) {
                        request['option'][variant.option_id] = this.selectedOptions[variant.option_id];
                        body += '&option[' + variant.option_id + ']=' + this.selectedOptions[variant.option_id];
                    }
                }
            );
            console.log('request: ', request, body);
            this.mainService.addToCart(body);
        }
    }

    private setOptionGroup(): void {
        this.variants.forEach(variant => {
            variant.options.forEach(
                option => {
                    this.setOptionItem(option);
                    this.setFormControl(option);
                }
            );
        });
    }

    private setOptionItem(option: Option): void {
        const group_index = this.optionGroups.findIndex(item => option.option_id === item.option_id);
        if (group_index < 0) {
            this.optionGroups.push({
                option_id: option.option_id,
                option_name: option.option_name,
                type: option.type,
                status: true,
                values: [option]
            });
        } else {
            if (!this.optionGroups[group_index].values.find(item => item.option_value_id === option.option_value_id)) {
                this.optionGroups[group_index].values.push(option);
            }
        }
    }

    private setFormControl(option: Option): void {
        const field = 'field_' + option.option_id;

        if (this.form.controls[field] === undefined) {
            this.form.controls[field] = new FormControl();
            this.data[option.option_id] = null;
        }
    }

    private setSelectedOptions(): void {
        this.optionGroups.forEach(variant => {
            if (this.data[variant.option_id]) {
                const option = variant.values.find(item => (item.option_value_id === this.data[variant.option_id]));
                this.selectedOptions[variant.option_id] = option.option_value_id;
            }
        });
    }

    private setVariantsStatus(): void {
        this.variants.forEach(
            variant => {
                variant.options.forEach(
                    (option, index) => {
                        if (
                            this.selectedOptions[option.option_id]
                            && this.selectedOptions[option.option_id] !== null
                            && this.selectedOptions[option.option_id] !== option.option_value_id
                        ) {
                            variant.status = false;
                            option.status = false;
                        }
                    }
                );
            }
        );
        this.setOptionGroup();
    }

    private enableAnotherGroup(option_id): void {
        const group_index = this.optionGroups.findIndex(item => option_id === item.option_id);
        this.optionGroups[group_index].values.forEach(
            (option, index) => {
                this.optionGroups[group_index].values[index].status = true;
            }
        );
    }
}
