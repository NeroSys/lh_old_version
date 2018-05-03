import {Injectable} from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import 'rxjs/add/operator/toPromise';
import {environment} from '../environments/environment';
import {Variant} from "./model/variant";
import {VariantCollection} from "./model/variant-collection";

@Injectable()
export class MainService {

    constructor(private http: HttpClient) {
    }

    getSpecifications(id_product: number): Promise<VariantCollection> {
        const url = `${environment.apiUrl}index.php?route=product/product/options/&product_id=${id_product}`;
        return this.http.get(url)
            .toPromise()
            .then(response => response as Variant[])
            .catch(this.handleError);
    }

    addToCart(data): Promise<any> {
        const headers = new HttpHeaders({ 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'});
        return this.http.post(`${environment.apiUrl}index.php?route=checkout/cart/add`, data, {headers: headers})
            .toPromise()
            .then(response => response)
            .catch(this.handleError);
    }

    private handleError(error: any): Promise<any> {
        console.error('An error occurred', error);
        return Promise.reject(error.message || error);
    }
}
