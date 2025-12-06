import {Column} from 'typeorm';

export class User
{
  private id: string;
  private name: string;
  private email: string;
  private passwordHash: string;

  constructor(id: string, name: string, email: string, passwordHash: string)
  {
    this.id = id;
    this.name = name;
    this.email = email;
    this.passwordHash = passwordHash;
  }

  idValue() {return this.id;}
  getName() {return this.name;}
  getEmail() {return this.email;}
  getPasswordHash() {return this.passwordHash;}

  changeName(name: string) {this.name = name;}
  changeEmail(email: string) {this.email = email;}
  changePasswordHash(hash: string) {this.passwordHash = hash;}

  toJSON()
  {return { id: this.id, name: this.name, email: this.email };}
}
