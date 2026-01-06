import UserController from './UserController'
import CategoryController from './CategoryController'
import BookController from './BookController'
const Admin = {
    UserController: Object.assign(UserController, UserController),
CategoryController: Object.assign(CategoryController, CategoryController),
BookController: Object.assign(BookController, BookController),
}

export default Admin
