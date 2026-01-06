import BookLoanController from './BookLoanController'
import MyrequestController from './MyrequestController'
const Anggota = {
    BookLoanController: Object.assign(BookLoanController, BookLoanController),
MyrequestController: Object.assign(MyrequestController, MyrequestController),
}

export default Anggota
