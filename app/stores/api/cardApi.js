export default {
  getCardList(columnUuid) {
    const query = gql`
        query getCards {
            cards(column_id: "${columnUuid}") {
                data {
                    id
                    uuid
                    title
                    position
                    description
                }
            }
        }
    `;

    return useQuery(query);
  },

  createCard(newCard) {
    const query = gql`
        mutation createCard {
            createCard(title: "${newCard.title}", column_id: "${newCard.column_id}") {
                id
                uuid
                title
                description
                position
            }
        }
    `;

    return useMutation(query);
  },

  updateCard(updateCard) {
    const query = gql`
        mutation updateCard {
            updateCard(
                id: "${updateCard.id}",
                title: "${updateCard.title}",
                description: "${updateCard.description}",
            ) {
                id
                uuid
                title
                description
                position
            }
        }
    `;

    return useMutation(query);
  },

  updateCardPosition(updateCard) {
    const query = gql`
        mutation updateCardPosition {
            updateCardPosition(
                id: "${updateCard.id}",
                position: ${updateCard.position},
            ) {
                id
                uuid
                title
                description
                position
            }
        }
    `;

    return useMutation(query);
  },

  updateCardColumn(updateCard) {
    const query = gql`
        mutation updateCardColumn {
            updateCardColumn(
                id: "${updateCard.id}",
                position: ${updateCard.position},
                column_id: "${updateCard.column_id}"
            ) {
                id
                uuid
                title
                description
                position
            }
        }
    `;

    return useMutation(query);
  },
};
